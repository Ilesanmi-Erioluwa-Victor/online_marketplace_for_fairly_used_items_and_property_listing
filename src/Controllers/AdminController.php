<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Mailer;
use App\Core\View;
use App\Models\User;

class AdminController extends BaseController
{
    public function dashboard(): void
    {
        Auth::requireAdmin();
        $db = Database::getConnection();
        $stats = [
            'users' => $db->query('SELECT COUNT(*) FROM users')->fetchColumn(),
            'items' => $db->query('SELECT COUNT(*) FROM item_listings')->fetchColumn(),
            'properties' => $db->query('SELECT COUNT(*) FROM property_listings')->fetchColumn(),
            'pending' => $db->query("SELECT (SELECT COUNT(*) FROM item_listings WHERE status='pending') + (SELECT COUNT(*) FROM property_listings WHERE status='pending')")->fetchColumn(),
            'revenue' => $db->query('SELECT COALESCE(SUM(amount),0) FROM featured_listings')->fetchColumn(),
        ];
        $recent = $db->query('SELECT * FROM users ORDER BY created_at DESC LIMIT 8')->fetchAll();
        $featured = $db->query('SELECT * FROM featured_listings ORDER BY created_at DESC LIMIT 20')->fetchAll();
        $this->render('admin/dashboard', compact('stats', 'recent', 'featured'));
    }

    public function pendingListings(): void
    {
        Auth::requireAdmin();
        $db = Database::getConnection();
        $items = $db->query("SELECT *, 'item' AS listing_table FROM item_listings WHERE status='pending' ORDER BY created_at DESC")->fetchAll();
        $properties = $db->query("SELECT *, 'property' AS listing_table FROM property_listings WHERE status='pending' ORDER BY created_at DESC")->fetchAll();
        $this->render('admin/listings-pending', compact('items', 'properties'));
    }

    public function moderateListing(): void
    {
        Csrf::verify();
        Auth::requireAdmin();
        $table = $_POST['listing_table'] === 'property' ? 'property_listings' : 'item_listings';
        $status = $_POST['action'] === 'approve' ? 'active' : 'rejected';
        Database::getConnection()->prepare("UPDATE {$table} SET status=?, rejection_reason=?, updated_at=NOW() WHERE id=?")->execute([$status, $_POST['reason'] ?? null, $_POST['listing_id']]);
        $this->emailListingOwner($table, (int) $_POST['listing_id'], $status, $_POST['reason'] ?? '');
        $_SESSION['flash'] = 'Listing moderated.';
        $this->redirect('/admin/listings-pending');
    }

    public function users(): void
    {
        Auth::requireAdmin();
        $users = Database::getConnection()->query('SELECT * FROM users ORDER BY created_at DESC')->fetchAll();
        $this->render('admin/users', compact('users'));
    }

    public function userAction(): void
    {
        Csrf::verify();
        Auth::requireAdmin();
        $db = Database::getConnection();
        if ($_POST['action'] === 'delete') {
            $db->prepare('DELETE FROM users WHERE id=? AND role <> ?')->execute([$_POST['user_id'], 'admin']);
        } else {
            $db->prepare('UPDATE users SET is_suspended=? WHERE id=?')->execute([$_POST['action'] === 'suspend' ? 'true' : 'false', $_POST['user_id']]);
        }
        $this->redirect('/admin/users');
    }

    public function reports(): void
    {
        Auth::requireAdmin();
        $reports = Database::getConnection()->query('SELECT r.*, u.full_name FROM reports r JOIN users u ON u.id=r.reporter_id ORDER BY r.created_at DESC')->fetchAll();
        $this->render('admin/reports', compact('reports'));
    }

    public function reportAction(): void
    {
        Csrf::verify();
        Auth::requireAdmin();
        $db = Database::getConnection();
        $status = $_POST['action'] === 'remove' ? 'removed' : 'dismissed';
        $db->prepare('UPDATE reports SET status=? WHERE id=?')->execute([$status, $_POST['report_id']]);
        if ($_POST['action'] === 'remove') {
            $table = $_POST['listing_table'] === 'property' ? 'property_listings' : 'item_listings';
            $db->prepare("UPDATE {$table} SET status='removed' WHERE id=?")->execute([$_POST['listing_id']]);
        }
        $this->redirect('/admin/reports');
    }

    public function analytics(): void
    {
        Auth::requireAdmin();
        $db = Database::getConnection();
        $itemCategories = $db->query('SELECT category label, COUNT(*) total FROM item_listings GROUP BY category ORDER BY total DESC')->fetchAll();
        $propertyTypes = $db->query('SELECT property_type label, COUNT(*) total FROM property_listings GROUP BY property_type ORDER BY total DESC')->fetchAll();
        $this->render('admin/analytics', compact('itemCategories', 'propertyTypes'));
    }

    private function emailListingOwner(string $table, int $id, string $status, string $reason): void
    {
        $stmt = Database::getConnection()->prepare("SELECT l.title, u.email, u.full_name FROM {$table} l JOIN users u ON u.id=l.user_id WHERE l.id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            $message = "Your listing '{$row['title']}' was {$status}." . ($reason ? ' Reason: ' . $reason : '');
            Mailer::send($row['email'], $row['full_name'], 'Listing ' . $status, View::email('notice', ['name' => $row['full_name'], 'message' => $message]));
        }
    }
}
