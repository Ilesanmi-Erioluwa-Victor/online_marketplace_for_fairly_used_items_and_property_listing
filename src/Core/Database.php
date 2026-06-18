<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $databaseUrl = $_ENV['DATABASE_URL'] ?? '';
            try {
                [$dsn, $user, $password] = self::parseDatabaseUrl($databaseUrl);
                self::$instance = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                error_log('DB connection failed: ' . $e->getMessage());
                throw new PDOException('Database connection failed.');
            }
        }
        return self::$instance;
    }

    private static function parseDatabaseUrl(string $url): array
    {
        if (str_starts_with($url, 'pgsql:')) {
            return [$url, null, null];
        }
        $parts = parse_url($url);
        if (!$parts || empty($parts['host'])) {
            throw new PDOException('Invalid DATABASE_URL.');
        }
        $db = ltrim($parts['path'] ?? '/postgres', '/');
        $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s;sslmode=require', $parts['host'], $parts['port'] ?? 5432, $db);
        return [$dsn, urldecode($parts['user'] ?? ''), urldecode($parts['pass'] ?? '')];
    }
}
