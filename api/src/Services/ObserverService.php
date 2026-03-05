<?php

declare(strict_types=1);

namespace WorkEddy\Api\Services;

use Doctrine\DBAL\Connection;
use RuntimeException;

final class ObserverService
{
    public function __construct(private Connection $db)
    {
    }

    public function rate(int $scanId, int $observerId, float $score, string $category, ?string $notes): array
    {
        if ($score < 0 || $score > 100) {
            throw new RuntimeException('observer_score must be between 0 and 100');
        }

        $scan = $this->db->fetchAssociative('SELECT id, organization_id FROM scans WHERE id = :id LIMIT 1', ['id' => $scanId]);
        if (!$scan) {
            throw new RuntimeException('Scan not found');
        }

        $observer = $this->db->fetchAssociative('SELECT id, organization_id, role FROM users WHERE id = :id LIMIT 1', ['id' => $observerId]);
        if (!$observer) {
            throw new RuntimeException('Observer not found');
        }

        if ((int) $observer['organization_id'] !== (int) $scan['organization_id']) {
            throw new RuntimeException('Observer and scan must belong to same organization');
        }

        if (!in_array((string) $observer['role'], ['observer', 'admin'], true)) {
            throw new RuntimeException('User is not allowed to submit observer ratings');
        }

        $this->db->executeStatement(
            'INSERT INTO observer_ratings (scan_id, observer_id, observer_score, observer_category, notes, created_at) VALUES (:scan_id, :observer_id, :observer_score, :observer_category, :notes, NOW())',
            ['scan_id' => $scanId, 'observer_id' => $observerId, 'observer_score' => $score, 'observer_category' => $category, 'notes' => $notes]
        );

        return [
            'id' => (int) $this->db->lastInsertId(),
            'scan_id' => $scanId,
            'observer_id' => $observerId,
            'observer_score' => $score,
            'observer_category' => $category,
            'notes' => $notes,
        ];
    }
}
