"""Redis queue listener for WorkEddy video processing jobs."""

from __future__ import annotations

import importlib.util
import json
import os
import time
from pathlib import Path

import pymysql
import redis


ROOT = Path(__file__).resolve().parent
VIDEO_WORKER = ROOT.parent / "video-worker" / "worker.py"


spec = importlib.util.spec_from_file_location("video_worker", VIDEO_WORKER)
if spec is None or spec.loader is None:
    raise RuntimeError("Unable to load video worker module")
video_worker = importlib.util.module_from_spec(spec)
spec.loader.exec_module(video_worker)


def db_connection() -> pymysql.connections.Connection:
    return pymysql.connect(
        host=os.getenv("DB_HOST", "localhost"),
        port=int(os.getenv("DB_PORT", "3306")),
        user=os.getenv("DB_USER", "workeddy"),
        password=os.getenv("DB_PASS", "workeddy"),
        database=os.getenv("DB_NAME", "workeddy"),
        autocommit=False,
        cursorclass=pymysql.cursors.DictCursor,
    )


def run() -> None:
    client = redis.Redis(
        host=os.getenv("REDIS_HOST", "localhost"),
        port=int(os.getenv("REDIS_PORT", "6379")),
        decode_responses=True,
    )
    queue_name = os.getenv("WORKER_QUEUE", "scan_jobs")
    print(f"[worker-runner] listening queue='{queue_name}'")

    while True:
        result = client.brpop(queue_name, timeout=5)
        if result is None:
            continue

        _, payload = result
        try:
            job = json.loads(payload)
            conn = db_connection()
            try:
                video_worker.process_scan_job(job, conn)
                conn.commit()
            except Exception as proc_error:  # noqa: BLE001
                conn.rollback()
                if "scan_id" in job:
                    err_msg = str(proc_error)
                    video_worker.mark_scan_invalid(int(job["scan_id"]), conn, err_msg)
                    conn.commit()
                raise proc_error
            finally:
                conn.close()
            print(f"[worker-runner] completed scan_id={job.get('scan_id')}")
        except json.JSONDecodeError:
            print(f"[worker-runner] invalid payload: {payload}")
        except Exception as exc:  # noqa: BLE001
            print(f"[worker-runner] job failed: {exc}")
            time.sleep(1)


if __name__ == "__main__":
    run()
