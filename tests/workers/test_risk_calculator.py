from __future__ import annotations

import importlib.util
import unittest
from pathlib import Path


MODULE_PATH = Path(__file__).resolve().parents[2] / "workers" / "video-worker" / "risk_calculator.py"
spec = importlib.util.spec_from_file_location("risk_calculator", MODULE_PATH)
assert spec and spec.loader
risk_calculator = importlib.util.module_from_spec(spec)
spec.loader.exec_module(risk_calculator)


class RiskCalculatorTests(unittest.TestCase):
    def test_score_video_low(self) -> None:
        result = risk_calculator.score_video(10.0, 0.1, 2)
        self.assertEqual(result["risk_category"], "low")

    def test_score_video_high(self) -> None:
        result = risk_calculator.score_video(70.0, 0.5, 30)
        self.assertIn(result["risk_category"], {"moderate", "high"})
        self.assertGreaterEqual(result["normalized_score"], 40.0)


if __name__ == "__main__":
    unittest.main()
