<?php
namespace App\Models;

use App\Core\Database;

class User
{
    public static function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([strtolower($email)]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO users (full_name,email,phone,password_hash,role) VALUES (?,?,?,?,?) RETURNING id');
        $stmt->execute([$data['full_name'], strtolower($data['email']), $data['phone'], password_hash($data['password'], PASSWORD_DEFAULT), $data['role']]);
        return (int) $stmt->fetchColumn();
    }

    public static function updateProfile(int $id, array $data): void
    {
        $stmt = Database::getConnection()->prepare('UPDATE users SET full_name=?, phone=?, bio=?, profile_picture_url=COALESCE(?, profile_picture_url) WHERE id=?');
        $stmt->execute([$data['full_name'], $data['phone'], $data['bio'], $data['profile_picture_url'] ?? null, $id]);
    }
}
