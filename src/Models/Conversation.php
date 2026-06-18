<?php
namespace App\Models;

use App\Core\Database;

class Conversation
{
    public static function findOrCreate(string $table, int $listingId, int $buyerId, int $sellerId): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT id FROM conversations WHERE listing_table=? AND listing_id=? AND buyer_id=? AND seller_id=?');
        $stmt->execute([$table, $listingId, $buyerId, $sellerId]);
        $id = $stmt->fetchColumn();
        if ($id) {
            return (int) $id;
        }
        $stmt = $db->prepare('INSERT INTO conversations (listing_table, listing_id, buyer_id, seller_id) VALUES (?,?,?,?) RETURNING id');
        $stmt->execute([$table, $listingId, $buyerId, $sellerId]);
        return (int) $stmt->fetchColumn();
    }

    public static function forUser(int $userId): array
    {
        $stmt = Database::getConnection()->prepare("SELECT c.*, m.body AS last_message, m.created_at AS last_message_at,
            buyer.full_name AS buyer_name, seller.full_name AS seller_name,
            COALESCE(i.title, p.title) AS listing_title
            FROM conversations c
            JOIN users buyer ON buyer.id=c.buyer_id JOIN users seller ON seller.id=c.seller_id
            LEFT JOIN item_listings i ON c.listing_table='item' AND i.id=c.listing_id
            LEFT JOIN property_listings p ON c.listing_table='property' AND p.id=c.listing_id
            LEFT JOIN LATERAL (SELECT body, created_at FROM messages WHERE conversation_id=c.id ORDER BY created_at DESC LIMIT 1) m ON true
            WHERE c.buyer_id=? OR c.seller_id=? ORDER BY COALESCE(m.created_at, c.created_at) DESC");
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll();
    }

    public static function findForUser(int $id, int $userId): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT * FROM conversations WHERE id=? AND (buyer_id=? OR seller_id=?)');
        $stmt->execute([$id, $userId, $userId]);
        return $stmt->fetch() ?: null;
    }
}
