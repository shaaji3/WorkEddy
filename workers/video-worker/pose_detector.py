"""Pose estimation helpers using MediaPipe."""

from __future__ import annotations

from math import degrees

import cv2
import mediapipe as mp
import numpy as np


def _angle_from_vertical(dx: float, dy: float) -> float:
    return abs(degrees(np.arctan2(dx, -dy)))


def estimate_pose_metrics(video_path: str, sample_every_n: int = 4) -> dict[str, float | int]:
    pose = mp.solutions.pose.Pose(static_image_mode=False, model_complexity=1)
    cap = cv2.VideoCapture(video_path)
    if not cap.isOpened():
        raise RuntimeError(f"Cannot open video: {video_path}")

    trunk_angles: list[float] = []
    shoulder_elevated_frames = 0
    sampled_frames = 0
    confidence_total = 0.0
    confidence_count = 0

    frame_idx = 0
    while True:
        ok, frame = cap.read()
        if not ok:
            break
        frame_idx += 1
        if frame_idx % sample_every_n != 0:
            continue

        sampled_frames += 1
        rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        res = pose.process(rgb)
        if not res.pose_landmarks:
            continue

        lms = res.pose_landmarks.landmark
        ls = lms[mp.solutions.pose.PoseLandmark.LEFT_SHOULDER]
        rs = lms[mp.solutions.pose.PoseLandmark.RIGHT_SHOULDER]
        lh = lms[mp.solutions.pose.PoseLandmark.LEFT_HIP]
        rh = lms[mp.solutions.pose.PoseLandmark.RIGHT_HIP]

        shoulder_x, shoulder_y = (ls.x + rs.x) / 2.0, (ls.y + rs.y) / 2.0
        hip_x, hip_y = (lh.x + rh.x) / 2.0, (lh.y + rh.y) / 2.0

        angle = _angle_from_vertical(shoulder_x - hip_x, shoulder_y - hip_y)
        trunk_angles.append(float(angle))

        if shoulder_y < 0.35:
            shoulder_elevated_frames += 1

        vis = (ls.visibility + rs.visibility + lh.visibility + rh.visibility) / 4.0
        confidence_total += float(vis)
        confidence_count += 1

    cap.release()
    pose.close()

    if not trunk_angles:
        raise RuntimeError("No pose landmarks detected in sampled frames")

    avg_trunk_angle = float(np.mean(trunk_angles))
    max_trunk_angle = float(np.max(trunk_angles))
    shoulder_elevation_duration = shoulder_elevated_frames / max(1, sampled_frames)

    rep = 0
    prev_high = False
    for a in trunk_angles:
        high = a >= 30.0
        if high and not prev_high:
            rep += 1
        prev_high = high

    return {
        "max_trunk_angle": round(max_trunk_angle, 2),
        "avg_trunk_angle": round(avg_trunk_angle, 2),
        "shoulder_elevation_duration": round(float(shoulder_elevation_duration), 4),
        "repetition_count": rep,
        "processing_confidence": round(confidence_total / max(1, confidence_count), 4),
    }
