<?php
use App\Core\Auth;
use App\Core\Csrf;

$currentUser = Auth::currentUser();
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
if (!class_exists('Csrf')) { class_alias(Csrf::class, 'Csrf'); }
function h($value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
function money($value): string { return '₦' . number_format((float) $value); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= h($title ?? 'Fairly Marketplace') ?></title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php require __DIR__ . '/nav.php'; ?>
<main class="container">
<?php if ($flash): ?><div class="flash"><?= h($flash) ?></div><?php endif; ?>
