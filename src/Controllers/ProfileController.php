<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Upload;
use App\Models\ItemListing;
use App\Models\PropertyListing;
use App\Models\User;

class ProfileController extends BaseController
{
    public function edit(): void
    {
        $user = Auth::requireAuth();
        $this->render('profile/edit', ['user' => $user, 'items' => ItemListing::byUser((int) $user['id']), 'properties' => PropertyListing::byUser((int) $user['id'])]);
    }

    public function update(): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        $url = null;
        if (!empty($_FILES['profile_picture']['tmp_name'])) {
            $mime = mime_content_type($_FILES['profile_picture']['tmp_name']);
            if (in_array($mime, $this->config['allowed_mimes'], true)) {
                $url = Upload::uploadFile($_FILES['profile_picture']['tmp_name'], 'profiles/' . Upload::safeName($_FILES['profile_picture']['name']), $mime);
            }
        }
        User::updateProfile((int) $user['id'], $_POST + ['profile_picture_url' => $url]);
        if (!empty($_POST['new_password']) && strlen($_POST['new_password']) >= 8) {
            Database::getConnection()->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([password_hash($_POST['new_password'], PASSWORD_DEFAULT), $user['id']]);
        }
        unset($_SESSION['user']);
        $_SESSION['flash'] = 'Profile updated.';
        $this->redirect('/profile');
    }

    public function show(string $id): void
    {
        $user = User::find((int) $id);
        if (!$user) { http_response_code(404); require __DIR__ . '/../../views/errors/404.php'; return; }
        $this->render('profile/show', ['publicUser' => $user, 'items' => ItemListing::byUser((int) $id), 'properties' => PropertyListing::byUser((int) $id)]);
    }
}
