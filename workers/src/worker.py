"""Compatibility entrypoint. Delegates to queue listener runner."""

from __future__ import annotations

import importlib.util
from pathlib import Path

RUNNER_PATH = Path(__file__).resolve().parents[1] / "queue-listener" / "worker_runner.py"

spec = importlib.util.spec_from_file_location("worker_runner", RUNNER_PATH)
if spec is None or spec.loader is None:
    raise RuntimeError("Unable to load worker runner")
module = importlib.util.module_from_spec(spec)
spec.loader.exec_module(module)


if __name__ == "__main__":
    module.run()
