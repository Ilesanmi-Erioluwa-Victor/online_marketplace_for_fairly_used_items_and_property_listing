<?php
use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Database;
use App\Models\Message;

$currentUser = Auth::currentUser();
$unreadCount = $currentUser ? Message::unreadCount((int) $currentUser['id']) : 0;
$pendingCount = $currentUser && ($currentUser['role'] ?? '') === 'admin' ? (int) Database::getConnection()->query("SELECT (SELECT COUNT(*) FROM item_listings WHERE status='pending') + (SELECT COUNT(*) FROM property_listings WHERE status='pending')")->fetchColumn() : 0;
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
if (!class_exists('Csrf')) { class_alias(Csrf::class, 'Csrf'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= h($title ?? 'Fairly Market') ?></title>
  <link rel="icon" type="image/svg+xml" href="/favicon.svg">
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php require __DIR__ . '/nav.php'; ?>
<main class="container">
<?php if ($flash): ?><div class="flash<?= str_contains($flash, 'successful') || str_contains($flash, 'created') || str_contains($flash, 'verified') || str_contains($flash, 'updated') ? ' flash-success' : '' ?>"><?= h($flash) ?></div><?php endif; ?>
