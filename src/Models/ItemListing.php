<?php
namespace App\Models;

use App\Core\Database;

class ItemListing
{
    public static function all(array $filters = [], int $limit = 12, int $offset = 0): array
    {
        [$where, $params, $order] = self::filterSql($filters);
        $sql = "SELECT i.*, u.full_name, (SELECT image_url FROM listing_images WHERE listing_table='item' AND listing_id=i.id LIMIT 1) image_url,
                EXISTS(SELECT 1 FROM featured_listings f WHERE f.listing_table='item' AND f.listing_id=i.id AND f.featured_until>NOW()) AS is_featured
                FROM item_listings i JOIN users u ON u.id=i.user_id WHERE i.status='active' {$where} {$order} LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare("SELECT i.*, u.full_name, u.email, u.phone, u.bio FROM item_listings i JOIN users u ON u.id=i.user_id WHERE i.id=?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function images(int $id): array
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM listing_images WHERE listing_table='item' AND listing_id=? ORDER BY id");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO item_listings (user_id,title,description,category,condition,price,quantity,status) VALUES (?,?,?,?,?,?,?,?) RETURNING id');
        $stmt->execute([$data['user_id'], $data['title'], $data['description'], $data['category'], $data['condition'], $data['price'], $data['quantity'], 'pending']);
        return (int) $stmt->fetchColumn();
    }

    public static function update(int $id, int $userId, array $data): void
    {
        $stmt = Database::getConnection()->prepare('UPDATE item_listings SET title=?, description=?, category=?, condition=?, price=?, quantity=?, status=?, updated_at=NOW() WHERE id=? AND user_id=?');
        $stmt->execute([$data['title'], $data['description'], $data['category'], $data['condition'], $data['price'], $data['quantity'], $data['status'], $id, $userId]);
    }

    public static function delete(int $id, int $userId): void
    {
        $stmt = Database::getConnection()->prepare("UPDATE item_listings SET status='removed', updated_at=NOW() WHERE id=? AND user_id=?");
        $stmt->execute([$id, $userId]);
    }

    public static function addImage(int $id, string $url): void
    {
        $stmt = Database::getConnection()->prepare("INSERT INTO listing_images (listing_id, listing_table, image_url) VALUES (?, 'item', ?)");
        $stmt->execute([$id, $url]);
    }

    public static function byUser(int $userId): array
    {
        $stmt = Database::getConnection()->prepare("SELECT *, 'item' AS listing_table FROM item_listings WHERE user_id=? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    private static function filterSql(array $filters): array
    {
        $where = '';
        $params = [];
        foreach (['category', 'condition'] as $field) {
            if (!empty($filters[$field])) {
                $where .= " AND i.{$field}=?";
                $params[] = $filters[$field];
            }
        }
        if (!empty($filters['q'])) {
            $where .= ' AND (i.title ILIKE ? OR i.description ILIKE ?)';
            $params[] = '%' . $filters['q'] . '%';
            $params[] = '%' . $filters['q'] . '%';
        }
        if ($filters['min_price'] ?? '') {
            $where .= ' AND i.price >= ?';
            $params[] = $filters['min_price'];
        }
        if ($filters['max_price'] ?? '') {
            $where .= ' AND i.price <= ?';
            $params[] = $filters['max_price'];
        }
        $order = match ($filters['sort'] ?? '') {
            'price_asc' => 'ORDER BY i.price ASC',
            'price_desc' => 'ORDER BY i.price DESC',
            default => 'ORDER BY is_featured DESC, i.created_at DESC',
        };
        return [$where, $params, $order];
    }
}
