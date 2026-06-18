<?php
namespace App\Models;

use App\Core\Database;

class Report
{
    public static function create(string $table, int $listingId, int $reporterId, string $reason, string $note): void
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO reports (listing_table, listing_id, reporter_id, reason, note) VALUES (?,?,?,?,?)');
        $stmt->execute([$table, $listingId, $reporterId, $reason, $note]);
    }
}
