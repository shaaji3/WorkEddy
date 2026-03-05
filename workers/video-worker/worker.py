"""Video worker processor implementation."""

from __future__ import annotations

import importlib.util
from pathlib import Path

import pymysql

ROOT = Path(__file__).resolve().parent


def _load(name: str, filename: str):
    spec = importlib.util.spec_from_file_location(name, ROOT / filename)
    if spec is None or spec.loader is None:
        raise RuntimeError(f"Unable to load module {filename}")
    module = importlib.util.module_from_spec(spec)
    spec.loader.exec_module(module)
    return module


frame_extractor = _load("frame_extractor", "frame_extractor.py")
pose_detector = _load("pose_detector", "pose_detector.py")
risk_calculator = _load("risk_calculator", "risk_calculator.py")


def process_scan_job(job: dict, conn: pymysql.connections.Connection) -> None:
    scan_id = int(job["scan_id"])
    organization_id = int(job["organization_id"])
    video_path = str(job["video_path"])

    frame_extractor.sample_frame_stats(video_path=video_path, sample_every_n=4)
    metrics = pose_detector.estimate_pose_metrics(video_path=video_path, sample_every_n=4)
    risk = risk_calculator.score_video(
        max_trunk_angle=float(metrics["max_trunk_angle"]),
        shoulder_elevation_duration=float(metrics["shoulder_elevation_duration"]),
        repetition_count=int(metrics["repetition_count"]),
    )

    with conn.cursor() as cursor:
        cursor.execute(
            """
            INSERT INTO video_metrics (scan_id, max_trunk_angle, avg_trunk_angle, shoulder_elevation_duration, repetition_count, processing_confidence)
            VALUES (%s, %s, %s, %s, %s, %s)
            ON DUPLICATE KEY UPDATE
                max_trunk_angle = VALUES(max_trunk_angle),
                avg_trunk_angle = VALUES(avg_trunk_angle),
                shoulder_elevation_duration = VALUES(shoulder_elevation_duration),
                repetition_count = VALUES(repetition_count),
                processing_confidence = VALUES(processing_confidence)
            """,
            (
                scan_id,
                metrics["max_trunk_angle"],
                metrics["avg_trunk_angle"],
                metrics["shoulder_elevation_duration"],
                metrics["repetition_count"],
                metrics["processing_confidence"],
            ),
        )
        cursor.execute(
            """
            UPDATE scans
            SET raw_score = %s,
                normalized_score = %s,
                risk_category = %s,
                status = 'completed'
            WHERE id = %s
            """,
            (risk['raw_score'], risk['normalized_score'], risk['risk_category'], scan_id),
        )
        cursor.execute(
            """
            INSERT INTO usage_records (organization_id, scan_id, usage_type, created_at)
            VALUES (%s, %s, 'video_scan', NOW())
            """,
            (organization_id, scan_id),
        )


def mark_scan_invalid(scan_id: int, conn: pymysql.connections.Connection) -> None:
    with conn.cursor() as cursor:
        cursor.execute("UPDATE scans SET status = 'invalid' WHERE id = %s", (scan_id,))
