<?php
namespace App\Core;

class Auth
{
    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user'] = $user;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    public static function currentUser(): ?array
    {
        if (!empty($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        if (empty($_SESSION['user_id'])) {
            return null;
        }
        $stmt = Database::getConnection()->prepare('SELECT * FROM users WHERE id = ? AND is_suspended = false');
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch() ?: null;
        $_SESSION['user'] = $user;
        return $user;
    }

    public static function requireAuth(): array
    {
        $user = self::currentUser();
        if (!$user) {
            header('Location: /login');
            exit;
        }
        return $user;
    }

    public static function requireAdmin(): array
    {
        $user = self::requireAuth();
        if (($user['role'] ?? '') !== 'admin') {
            http_response_code(403);
            exit('Admins only.');
        }
        return $user;
    }
}
