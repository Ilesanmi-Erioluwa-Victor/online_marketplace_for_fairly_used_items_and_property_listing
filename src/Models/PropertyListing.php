<?php
namespace App\Models;

use App\Core\Database;

class PropertyListing
{
    public static function count(array $filters = []): int
    {
        [$where, $params, $_] = self::filterSql($filters);
        $sql = "SELECT COUNT(*) FROM property_listings p JOIN users u ON u.id=p.user_id WHERE p.status='active' {$where}";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public static function all(array $filters = [], int $limit = 12, int $offset = 0): array
    {
        [$where, $params, $order] = self::filterSql($filters);
        $sql = "SELECT p.*, u.full_name, (SELECT image_url FROM listing_images WHERE listing_table='property' AND listing_id=p.id LIMIT 1) image_url,
                EXISTS(SELECT 1 FROM featured_listings f WHERE f.listing_table='property' AND f.listing_id=p.id AND f.featured_until>NOW()) AS is_featured
                FROM property_listings p JOIN users u ON u.id=p.user_id WHERE p.status='active' {$where} {$order} LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare("SELECT p.*, u.full_name, u.email, u.phone, u.bio FROM property_listings p JOIN users u ON u.id=p.user_id WHERE p.id=?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function images(int $id): array
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM listing_images WHERE listing_table='property' AND listing_id=? ORDER BY id");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO property_listings (user_id,title,description,listing_type,property_type,price,rent_period,bedrooms,bathrooms,size_sqft,address,city,state,amenities,status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) RETURNING id');
        $stmt->execute([$data['user_id'], $data['title'], $data['description'], $data['listing_type'], $data['property_type'], $data['price'], $data['rent_period'] ?: null, $data['bedrooms'], $data['bathrooms'], $data['size_sqft'], $data['address'], $data['city'], $data['state'], json_encode($data['amenities'] ?? []), 'pending']);
        return (int) $stmt->fetchColumn();
    }

    public static function update(int $id, int $userId, array $data): void
    {
        $stmt = Database::getConnection()->prepare('UPDATE property_listings SET title=?, description=?, listing_type=?, property_type=?, price=?, rent_period=?, bedrooms=?, bathrooms=?, size_sqft=?, address=?, city=?, state=?, amenities=?, status=?, updated_at=NOW() WHERE id=? AND user_id=?');
        $stmt->execute([$data['title'], $data['description'], $data['listing_type'], $data['property_type'], $data['price'], $data['rent_period'] ?: null, $data['bedrooms'], $data['bathrooms'], $data['size_sqft'], $data['address'], $data['city'], $data['state'], json_encode($data['amenities'] ?? []), $data['status'], $id, $userId]);
    }

    public static function delete(int $id, int $userId): void
    {
        $stmt = Database::getConnection()->prepare("UPDATE property_listings SET status='removed', updated_at=NOW() WHERE id=? AND user_id=?");
        $stmt->execute([$id, $userId]);
    }

    public static function addImage(int $id, string $url): void
    {
        $stmt = Database::getConnection()->prepare("INSERT INTO listing_images (listing_id, listing_table, image_url) VALUES (?, 'property', ?)");
        $stmt->execute([$id, $url]);
    }

    public static function byUser(int $userId): array
    {
        $stmt = Database::getConnection()->prepare("SELECT *, 'property' AS listing_table FROM property_listings WHERE user_id=? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    private static function filterSql(array $filters): array
    {
        $where = '';
        $params = [];
        foreach (['listing_type', 'property_type', 'city', 'state'] as $field) {
            if (!empty($filters[$field])) {
                $where .= " AND p.{$field} ILIKE ?";
                $params[] = $filters[$field];
            }
        }
        if (!empty($filters['q'])) {
            $where .= ' AND (p.title ILIKE ? OR p.description ILIKE ? OR p.city ILIKE ? OR p.state ILIKE ?)';
            for ($i = 0; $i < 4; $i++) {
                $params[] = '%' . $filters['q'] . '%';
            }
        }
        if ($filters['min_price'] ?? '') {
            $where .= ' AND p.price >= ?';
            $params[] = $filters['min_price'];
        }
        if ($filters['max_price'] ?? '') {
            $where .= ' AND p.price <= ?';
            $params[] = $filters['max_price'];
        }
        if ($filters['bedrooms'] ?? '') {
            $where .= ' AND p.bedrooms >= ?';
            $params[] = $filters['bedrooms'];
        }
        if (!empty($filters['amenities'])) {
            foreach ((array) $filters['amenities'] as $amenity) {
                $where .= ' AND p.amenities @> ?::jsonb';
                $params[] = json_encode([$amenity]);
            }
        }
        $order = match ($filters['sort'] ?? '') {
            'price_asc' => 'ORDER BY p.price ASC',
            'price_desc' => 'ORDER BY p.price DESC',
            default => 'ORDER BY is_featured DESC, p.created_at DESC',
        };
        return [$where, $params, $order];
    }
}
