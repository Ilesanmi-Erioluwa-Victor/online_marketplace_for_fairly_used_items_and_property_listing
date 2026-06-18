<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Mailer;
use App\Core\View;
use App\Models\Conversation;
use App\Models\ItemListing;
use App\Models\Report;

class ItemController extends BaseController
{
    public function index(): void { $this->render('items/index', ['items' => ItemListing::all($_GET), 'filters' => $_GET]); }
    public function create(): void { Auth::requireAuth(); $this->render('items/create'); }

    public function store(): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        if (!$user['is_verified']) { $_SESSION['flash'] = 'Verify your email before posting.'; $this->redirect('/items/create'); }
        $id = ItemListing::create(['user_id' => $user['id']] + $_POST);
        $this->handleImages($_FILES['images'] ?? [], fn($url) => ItemListing::addImage($id, $url), 'items');
        $_SESSION['flash'] = 'Item submitted for admin approval.';
        $this->redirect('/items/' . $id);
    }

    public function show(string $id): void
    {
        $item = ItemListing::find((int) $id);
        if (!$item) { http_response_code(404); require __DIR__ . '/../../views/errors/404.php'; return; }
        $this->render('items/show', ['item' => $item, 'images' => ItemListing::images((int) $id)]);
    }

    public function edit(string $id): void
    {
        $user = Auth::requireAuth();
        $item = ItemListing::find((int) $id);
        if (!$item || (int) $item['user_id'] !== (int) $user['id']) { http_response_code(403); exit('Forbidden'); }
        $this->render('items/edit', ['item' => $item]);
    }

    public function update(string $id): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        ItemListing::update((int) $id, (int) $user['id'], $_POST);
        $this->handleImages($_FILES['images'] ?? [], fn($url) => ItemListing::addImage((int) $id, $url), 'items');
        $_SESSION['flash'] = 'Item updated.';
        $this->redirect('/items/' . $id);
    }

    public function delete(string $id): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        ItemListing::delete((int) $id, (int) $user['id']);
        $_SESSION['flash'] = 'Item removed.';
        $this->redirect('/profile');
    }

    public function report(string $id): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        Report::create('item', (int) $id, (int) $user['id'], $_POST['reason'] ?? 'Concern', $_POST['note'] ?? '');
        $_SESSION['flash'] = 'Report submitted.';
        $this->redirect('/items/' . $id);
    }
}
