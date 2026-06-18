<?php
namespace App\Models;

use App\Core\Database;

class Message
{
    public static function recentAllowed(int $senderId): bool
    {
        $stmt = Database::getConnection()->prepare("SELECT COUNT(*) FROM messages WHERE sender_id=? AND created_at > NOW() - INTERVAL '10 seconds'");
        $stmt->execute([$senderId]);
        return (int) $stmt->fetchColumn() === 0;
    }

    public static function create(int $conversationId, int $senderId, string $body): void
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO messages (conversation_id, sender_id, body) VALUES (?,?,?)');
        $stmt->execute([$conversationId, $senderId, $body]);
    }

    public static function forConversation(int $conversationId): array
    {
        $stmt = Database::getConnection()->prepare('SELECT m.*, u.full_name FROM messages m JOIN users u ON u.id=m.sender_id WHERE conversation_id=? ORDER BY m.created_at ASC');
        $stmt->execute([$conversationId]);
        return $stmt->fetchAll();
    }
}
