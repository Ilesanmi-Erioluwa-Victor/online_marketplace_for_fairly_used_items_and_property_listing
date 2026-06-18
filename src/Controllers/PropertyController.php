<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Models\PropertyListing;
use App\Models\Report;

class PropertyController extends BaseController
{
    public function index(): void
    {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 12;
        $total = PropertyListing::count($_GET);
        $properties = PropertyListing::all($_GET, $perPage, ($page - 1) * $perPage);
        $this->render('properties/index', [
            'properties' => $properties,
            'filters' => $_GET,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'totalPages' => (int) ceil($total / $perPage),
        ]);
    }
    public function create(): void { $user = Auth::requireAuth(); if (!$user['is_verified']) { $_SESSION['flash'] = 'Verify your email before posting.'; $this->redirect('/'); } $this->render('properties/create'); }

    public function store(): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        if (!$user['is_verified']) { $_SESSION['flash'] = 'Verify your email before posting.'; $this->redirect('/properties/create'); }
        $id = PropertyListing::create(['user_id' => $user['id'], 'amenities' => $_POST['amenities'] ?? []] + $_POST);
        $this->handleImages($_FILES['images'] ?? [], fn($url) => PropertyListing::addImage($id, $url), 'properties');
        $_SESSION['flash'] = 'Property submitted for admin approval.';
        $this->redirect('/properties/' . $id);
    }

    public function show(string $id): void
    {
        $property = PropertyListing::find((int) $id);
        if (!$property) { http_response_code(404); require __DIR__ . '/../../views/errors/404.php'; return; }
        $this->render('properties/show', ['property' => $property, 'images' => PropertyListing::images((int) $id)]);
    }

    public function edit(string $id): void
    {
        $user = Auth::requireAuth();
        $property = PropertyListing::find((int) $id);
        if (!$property || (int) $property['user_id'] !== (int) $user['id']) { http_response_code(403); exit('Forbidden'); }
        $this->render('properties/edit', ['property' => $property]);
    }

    public function update(string $id): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        PropertyListing::update((int) $id, (int) $user['id'], ['amenities' => $_POST['amenities'] ?? []] + $_POST);
        $this->handleImages($_FILES['images'] ?? [], fn($url) => PropertyListing::addImage((int) $id, $url), 'properties');
        $_SESSION['flash'] = 'Property updated.';
        $this->redirect('/properties/' . $id);
    }

    public function delete(string $id): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        PropertyListing::delete((int) $id, (int) $user['id']);
        $_SESSION['flash'] = 'Property removed.';
        $this->redirect('/profile');
    }

    public function report(string $id): void
    {
        Csrf::verify();
        $user = Auth::requireAuth();
        Report::create('property', (int) $id, (int) $user['id'], $_POST['reason'] ?? 'Concern', $_POST['note'] ?? '');
        $_SESSION['flash'] = 'Report submitted.';
        $this->redirect('/properties/' . $id);
    }
}
