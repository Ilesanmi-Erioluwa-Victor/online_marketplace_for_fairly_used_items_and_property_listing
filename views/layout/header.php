<?php
use App\Core\Auth;
use App\Core\Csrf;

$currentUser = Auth::currentUser();
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
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php require __DIR__ . '/nav.php'; ?>
<main class="container">
<?php if ($flash): ?><div class="flash<?= str_contains($flash, 'successful') || str_contains($flash, 'created') || str_contains($flash, 'verified') || str_contains($flash, 'updated') ? ' flash-success' : '' ?>"><?= h($flash) ?></div><?php endif; ?>
