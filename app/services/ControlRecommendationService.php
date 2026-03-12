<?php

declare(strict_types=1);

namespace WorkEddy\Services;

final class ControlRecommendationService
{
    private const ENGINE_VERSION = 'ctrl_rec_v1_1';

    private const DEFAULT_POLICY = [
        'thresholds' => [
            'trunk_flexion_high' => 45.0,
            'trunk_flexion_moderate' => 25.0,
            'upper_arm_elevation_high' => 60.0,
            'repetition_high' => 20,
            'lifting_load' => 12.0,
        ],
        'risk_multipliers' => [
            'high' => 1.15,
            'moderate' => 1.0,
            'low' => 0.9,
        ],
        'ranking' => [
            'cost_penalty_factor' => 1.1,
            'impact_penalty_factor' => 0.8,
            'reduction_factor' => 1.0,
            'cost_weight' => ['low' => 1, 'medium' => 3, 'high' => 6],
            'impact_weight' => ['low' => 1, 'medium' => 3, 'high' => 5],
            'hierarchy_bonus' => [
                'elimination' => 7,
                'substitution' => 5,
                'engineering' => 4,
                'administrative' => 2,
                'ppe' => 0,
            ],
        ],
        'catalog' => [],
    ];

    public function version(): string
    {
        return self::ENGINE_VERSION;
    }

    /**
     * @param array<string,mixed> $metrics
     * @param array<string,mixed> $score
     * @param array<string,mixed> $policy
     * @return list<array<string,mixed>>
     */
    public function recommend(string $model, array $metrics, array $score, array $policy = []): array
    {
        $policy = $this->mergedPolicy($policy);
        $normalized = (float) ($score['normalized_score'] ?? 0.0);
        $riskCategory = (string) ($score['risk_category'] ?? 'low');

        $candidates = [];
        $drivers = $this->detectDrivers($metrics, $model, $policy);

        foreach ($drivers as $driver) {
            $candidates = array_merge($candidates, $this->catalogForDriver($driver, $metrics, $normalized, $policy));
        }

        // Always keep one broad governance / training recommendation as baseline.
        $candidates[] = [
            'hierarchy_level' => 'administrative',
            'control_code' => 'ADMIN_MICRO_BREAK_STANDARD',
            'title' => 'Enforce task-level micro-break and rotation standard',
            'expected_risk_reduction_pct' => max(6.0, min(18.0, round($normalized * 0.12, 2))),
            'implementation_cost' => 'low',
            'time_to_deploy_days' => 3,
            'throughput_impact' => 'low',
            'rationale' => 'Short recovery windows and rotation reduce cumulative exposure for repetitive work.',
            'evidence' => [
                'driver' => 'baseline_cumulative_exposure',
                'model' => $model,
                'normalized_score' => $normalized,
            ],
            'recommendation_engine_version' => $this->version(),
        ];

        $ranked = $this->rankAndDedupe($candidates, $riskCategory, $policy);

        $result = [];
        $rank = 1;
        foreach (array_slice($ranked, 0, 5) as $row) {
            $row['rank_order'] = $rank++;
            $row['recommendation_engine_version'] ??= $this->version();
            $result[] = $row;
        }

        return $result;
    }

    /**
     * @param array<string,mixed> $metrics
     * @return list<string>
     */
    private function detectDrivers(array $metrics, string $model, array $policy): array
    {
        $thresholds = $policy['thresholds'] ?? [];

        $drivers = [];

        $trunk = (float) ($metrics['trunk_angle'] ?? 0.0);
        if ($trunk >= (float) ($thresholds['trunk_flexion_high'] ?? 45.0)) {
            $drivers[] = 'trunk_flexion_high';
        } elseif ($trunk >= (float) ($thresholds['trunk_flexion_moderate'] ?? 25.0)) {
            $drivers[] = 'trunk_flexion_moderate';
        }

        $upperArm = (float) ($metrics['upper_arm_angle'] ?? 0.0);
        if ($upperArm >= (float) ($thresholds['upper_arm_elevation_high'] ?? 60.0)) {
            $drivers[] = 'upper_arm_elevation_high';
        }

        $repetition = (int) ($metrics['repetition_count'] ?? 0);
        if ($repetition >= (int) ($thresholds['repetition_high'] ?? 20)) {
            $drivers[] = 'repetition_high';
        }

        $loadWeight = (float) ($metrics['load_weight'] ?? 0.0);
        if ($loadWeight >= (float) ($thresholds['lifting_load'] ?? 12.0) || $model === 'niosh') {
            $drivers[] = 'lifting_load';
        }

        if ($drivers === []) {
            $drivers[] = 'general_risk';
        }

        return array_values(array_unique($drivers));
    }

    /**
     * @param array<string,mixed> $metrics
     * @return list<array<string,mixed>>
     */
    private function catalogForDriver(string $driver, array $metrics, float $normalized, array $policy): array
    {
        $base = match ($driver) {
            'trunk_flexion_high', 'trunk_flexion_moderate' => [
                [
                    'hierarchy_level' => 'engineering',
                    'control_code' => 'ENG_LIFT_ASSIST',
                    'title' => 'Deploy lift-assist or height-adjustable handling station',
                    'expected_risk_reduction_pct' => 28.0,
                    'implementation_cost' => 'high',
                    'time_to_deploy_days' => 21,
                    'throughput_impact' => 'low',
                    'rationale' => 'Reducing trunk flexion at source directly lowers spinal loading exposure.',
                    'evidence' => [
                        'driver' => $driver,
                        'trunk_angle' => (float) ($metrics['trunk_angle'] ?? 0.0),
                        'score_basis' => $normalized,
                    ],
                    'recommendation_engine_version' => $this->version(),
                ],
                [
                    'hierarchy_level' => 'administrative',
                    'control_code' => 'ADMIN_WORK_HEIGHT_SETUP',
                    'title' => 'Standardize workstation setup check at shift start',
                    'expected_risk_reduction_pct' => 14.0,
                    'implementation_cost' => 'low',
                    'time_to_deploy_days' => 2,
                    'throughput_impact' => 'low',
                    'rationale' => 'Daily setup checks reduce sustained awkward posture from misaligned work heights.',
                    'evidence' => [
                        'driver' => $driver,
                        'trunk_angle' => (float) ($metrics['trunk_angle'] ?? 0.0),
                    ],
                    'recommendation_engine_version' => $this->version(),
                ],
            ],
            'upper_arm_elevation_high' => [
                [
                    'hierarchy_level' => 'engineering',
                    'control_code' => 'ENG_REACH_REDESIGN',
                    'title' => 'Redesign reach zone to keep picks in shoulder-safe envelope',
                    'expected_risk_reduction_pct' => 22.0,
                    'implementation_cost' => 'medium',
                    'time_to_deploy_days' => 10,
                    'throughput_impact' => 'medium',
                    'rationale' => 'Repositioning high-frequency items reduces elevated shoulder postures.',
                    'evidence' => [
                        'driver' => $driver,
                        'upper_arm_angle' => (float) ($metrics['upper_arm_angle'] ?? 0.0),
                    ],
                    'recommendation_engine_version' => $this->version(),
                ],
            ],
            'repetition_high' => [
                [
                    'hierarchy_level' => 'administrative',
                    'control_code' => 'ADMIN_JOB_ROTATION',
                    'title' => 'Implement evidence-based rotation cadence for repetitive tasks',
                    'expected_risk_reduction_pct' => 18.0,
                    'implementation_cost' => 'low',
                    'time_to_deploy_days' => 5,
                    'throughput_impact' => 'medium',
                    'rationale' => 'Rotation disperses cumulative load and reduces repetitive strain concentration.',
                    'evidence' => [
                        'driver' => $driver,
                        'repetition_count' => (int) ($metrics['repetition_count'] ?? 0),
                    ],
                    'recommendation_engine_version' => $this->version(),
                ],
            ],
            'lifting_load' => [
                [
                    'hierarchy_level' => 'substitution',
                    'control_code' => 'SUB_PACK_SIZE_REDUCTION',
                    'title' => 'Reduce unit load per lift (repack or split loads)',
                    'expected_risk_reduction_pct' => 20.0,
                    'implementation_cost' => 'medium',
                    'time_to_deploy_days' => 14,
                    'throughput_impact' => 'medium',
                    'rationale' => 'Lowering load weight reduces required lifting index and peak exertion.',
                    'evidence' => [
                        'driver' => $driver,
                        'load_weight' => (float) ($metrics['load_weight'] ?? 0.0),
                    ],
                    'recommendation_engine_version' => $this->version(),
                ],
                [
                    'hierarchy_level' => 'engineering',
                    'control_code' => 'ENG_HANDLING_AID',
                    'title' => 'Introduce handling aid for high-load lifts',
                    'expected_risk_reduction_pct' => 26.0,
                    'implementation_cost' => 'high',
                    'time_to_deploy_days' => 18,
                    'throughput_impact' => 'low',
                    'rationale' => 'Mechanical assistance lowers spinal and shoulder loading for heavy lifts.',
                    'evidence' => [
                        'driver' => $driver,
                        'load_weight' => (float) ($metrics['load_weight'] ?? 0.0),
                    ],
                    'recommendation_engine_version' => $this->version(),
                ],
            ],
            default => [
                [
                    'hierarchy_level' => 'administrative',
                    'control_code' => 'ADMIN_TARGETED_COACHING',
                    'title' => 'Run targeted coaching for high-risk task execution',
                    'expected_risk_reduction_pct' => 10.0,
                    'implementation_cost' => 'low',
                    'time_to_deploy_days' => 2,
                    'throughput_impact' => 'low',
                    'rationale' => 'Immediate coaching improves movement quality while engineering changes are planned.',
                    'evidence' => [
                        'driver' => 'general_risk',
                        'score_basis' => $normalized,
                    ],
                    'recommendation_engine_version' => $this->version(),
                ],
            ],
        };

        $catalog = $policy['catalog'] ?? [];
        $custom = $catalog[$driver] ?? [];
        if (!is_array($custom) || $custom === []) {
            return $base;
        }

        foreach ($custom as &$row) {
            if (!is_array($row)) {
                continue;
            }
            $row['recommendation_engine_version'] = (string) ($row['recommendation_engine_version'] ?? $this->version());
            $row['evidence'] = is_array($row['evidence'] ?? null) ? $row['evidence'] : ['driver' => $driver, 'custom' => true];
        }
        unset($row);

        return array_merge($base, array_values(array_filter($custom, 'is_array')));
    }

    /**
     * @param list<array<string,mixed>> $rows
     * @return list<array<string,mixed>>
     */
    private function rankAndDedupe(array $rows, string $riskCategory, array $policy): array
    {
        $ranking = $policy['ranking'] ?? [];
        $costWeight = is_array($ranking['cost_weight'] ?? null) ? $ranking['cost_weight'] : ['low' => 1, 'medium' => 3, 'high' => 6];
        $impactWeight = is_array($ranking['impact_weight'] ?? null) ? $ranking['impact_weight'] : ['low' => 1, 'medium' => 3, 'high' => 5];
        $hierarchyBonus = is_array($ranking['hierarchy_bonus'] ?? null) ? $ranking['hierarchy_bonus'] : ['elimination' => 7, 'substitution' => 5, 'engineering' => 4, 'administrative' => 2, 'ppe' => 0];
        $costPenaltyFactor = (float) ($ranking['cost_penalty_factor'] ?? 1.1);
        $impactPenaltyFactor = (float) ($ranking['impact_penalty_factor'] ?? 0.8);
        $reductionFactor = (float) ($ranking['reduction_factor'] ?? 1.0);

        // High risk context should prioritize stronger controls.
        $riskMultipliers = $policy['risk_multipliers'] ?? [];
        $riskMultiplier = (float) ($riskMultipliers[$riskCategory] ?? $riskMultipliers['moderate'] ?? 1.0);

        $seen = [];
        $ranked = [];

        foreach ($rows as $row) {
            $code = (string) ($row['control_code'] ?? '');
            if ($code === '' || isset($seen[$code])) {
                continue;
            }
            $seen[$code] = true;

            $reduction = (float) ($row['expected_risk_reduction_pct'] ?? 0.0);
            $cost = $costWeight[(string) ($row['implementation_cost'] ?? 'medium')] ?? 3;
            $impact = $impactWeight[(string) ($row['throughput_impact'] ?? 'medium')] ?? 3;
            $hierarchy = $hierarchyBonus[(string) ($row['hierarchy_level'] ?? 'administrative')] ?? 0;

            $score = ($reduction * $riskMultiplier * $reductionFactor) + $hierarchy - ($cost * $costPenaltyFactor) - ($impact * $impactPenaltyFactor);
            $row['_rank_score'] = round($score, 4);
            $ranked[] = $row;
        }

        usort($ranked, static function (array $a, array $b): int {
            return ($b['_rank_score'] <=> $a['_rank_score']);
        });

        foreach ($ranked as &$row) {
            unset($row['_rank_score']);
        }
        unset($row);

        return $ranked;
    }

    /**
     * @param array<string,mixed> $policy
     * @return array<string,mixed>
     */
    private function mergedPolicy(array $policy): array
    {
        $merged = self::DEFAULT_POLICY;

        foreach (['thresholds', 'risk_multipliers', 'ranking', 'catalog'] as $key) {
            if (!isset($policy[$key]) || !is_array($policy[$key])) {
                continue;
            }

            if ($key === 'catalog') {
                $merged[$key] = $policy[$key];
                continue;
            }

            $merged[$key] = array_replace($merged[$key], $policy[$key]);
        }

        return $merged;
    }
}
