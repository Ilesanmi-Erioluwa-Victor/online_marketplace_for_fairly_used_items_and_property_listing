<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Mailer;
use App\Core\Validator;
use App\Core\View;
use App\Models\User;

class AuthController extends BaseController
{
    public function showRegister(): void { $this->render('auth/register'); }
    public function showLogin(): void { $this->render('auth/login'); }
    public function showForgotPassword(): void { $this->render('auth/forgot-password'); }

    public function register(): void
    {
        try {
            Csrf::verify();
            $errors = Validator::required($_POST, ['full_name', 'email', 'phone', 'password', 'role']);
            if (!Validator::email($_POST['email'] ?? '')) {
                $errors['email'] = 'Enter a valid email.';
            }
            if (strlen($_POST['password'] ?? '') < 8) {
                $errors['password'] = 'Password must be at least 8 characters.';
            }
            if ($errors || User::findByEmail($_POST['email'])) {
                $_SESSION['flash'] = 'Registration failed. Check your details or use another email.';
                $this->redirect('/register');
            }
            $id = User::create($_POST);
            $token = bin2hex(random_bytes(32));
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO email_verifications (user_id, token, expires_at) VALUES (?,?,NOW() + INTERVAL '24 hours')");
            $stmt->execute([$id, $token]);
            $link = $this->config['app_url'] . '/verify-email?token=' . urlencode($token);
            Mailer::send($_POST['email'], $_POST['full_name'], 'Verify your Fairly Marketplace account', View::email('verification', ['name' => $_POST['full_name'], 'link' => $link]));
            Mailer::send($_POST['email'], $_POST['full_name'], 'Welcome to Fairly Marketplace', View::email('notice', ['name' => $_POST['full_name'], 'message' => 'Your account has been created. Please verify your email before posting listings.']));
            $_SESSION['flash'] = 'Account created. Check your email for verification.';
            $this->redirect('/login');
        } catch (\Throwable $e) {
            error_log('REGISTRATION ERROR: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            http_response_code(500);
            echo 'Registration failed: ' . $e->getMessage();
        }
    }

    public function login(): void
    {
        Csrf::verify();
        $user = User::findByEmail($_POST['email'] ?? '');
        if (!$user || $user['is_suspended'] || !password_verify($_POST['password'] ?? '', $user['password_hash'])) {
            $_SESSION['flash'] = 'Invalid login details.';
            $this->redirect('/login');
        }
        Auth::login($user);
        $this->redirect('/');
    }

    public function logout(): void
    {
        Csrf::verify();
        Auth::logout();
        $this->redirect('/');
    }

    public function verifyEmail(): void
    {
        $token = $_GET['token'] ?? '';
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM email_verifications WHERE token=? AND expires_at > NOW()");
        $stmt->execute([$token]);
        $row = $stmt->fetch();
        if ($row) {
            $db->prepare('UPDATE users SET is_verified=true WHERE id=?')->execute([$row['user_id']]);
            $db->prepare('DELETE FROM email_verifications WHERE user_id=?')->execute([$row['user_id']]);
            $_SESSION['flash'] = 'Email verified. You can now post listings.';
        } else {
            $_SESSION['flash'] = 'Verification link is invalid or expired.';
        }
        $this->redirect('/login');
    }

    public function forgotPassword(): void
    {
        Csrf::verify();
        $user = User::findByEmail($_POST['email'] ?? '');
        if ($user) {
            $token = bin2hex(random_bytes(32));
            Database::getConnection()->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?,?,NOW() + INTERVAL '1 hour')")->execute([$user['id'], $token]);
            $link = $this->config['app_url'] . '/reset-password?token=' . urlencode($token);
            Mailer::send($user['email'], $user['full_name'], 'Reset your password', View::email('reset', ['name' => $user['full_name'], 'link' => $link]));
        }
        $_SESSION['flash'] = 'If that email exists, a reset link has been sent.';
        $this->redirect('/forgot-password');
    }

    public function showResetPassword(): void
    {
        $this->render('auth/reset-password', ['token' => $_GET['token'] ?? '']);
    }

    public function resetPassword(): void
    {
        Csrf::verify();
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM password_resets WHERE token=? AND expires_at > NOW()");
        $stmt->execute([$_POST['token'] ?? '']);
        $row = $stmt->fetch();
        if (!$row || strlen($_POST['password'] ?? '') < 8) {
            $_SESSION['flash'] = 'Reset link invalid or password too short.';
            $this->redirect('/reset-password?token=' . urlencode($_POST['token'] ?? ''));
        }
        $db->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([password_hash($_POST['password'], PASSWORD_DEFAULT), $row['user_id']]);
        $db->prepare('DELETE FROM password_resets WHERE user_id=?')->execute([$row['user_id']]);
        $_SESSION['flash'] = 'Password reset. Log in with your new password.';
        $this->redirect('/login');
    }
}
