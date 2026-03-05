"""Risk scoring for video metrics."""

from __future__ import annotations


def score_video(max_trunk_angle: float, shoulder_elevation_duration: float, repetition_count: int) -> dict[str, float | str]:
    score = 0.0

    if max_trunk_angle > 60:
        score += 30
    elif max_trunk_angle > 45:
        score += 20
    elif max_trunk_angle > 20:
        score += 10

    if shoulder_elevation_duration > 0.3:
        score += 20
    elif shoulder_elevation_duration > 0.15:
        score += 10

    if repetition_count >= 25:
        score += 15
    elif repetition_count >= 10:
        score += 8

    normalized = max(0.0, min(100.0, round(score, 2)))
    if normalized >= 70:
        category = "high"
    elif normalized >= 40:
        category = "moderate"
    else:
        category = "low"

    return {
        "raw_score": round(score, 2),
        "normalized_score": normalized,
        "risk_category": category,
    }
