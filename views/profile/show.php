<h1><?= h($publicUser['full_name']) ?></h1>
<?php if ($publicUser['profile_picture_url']): ?><img class="avatar" src="<?= h($publicUser['profile_picture_url']) ?>" alt=""><?php endif; ?>
<p><?= nl2br(h($publicUser['bio'] ?? '')) ?></p>
<p><?= h($publicUser['phone'] ?? '') ?> · Joined <?= h(date('M j, Y', strtotime($publicUser['created_at']))) ?></p>
<h2>Active Items</h2>
<?php $items = array_values(array_filter($items, fn($x) => $x['status'] === 'active')); require __DIR__ . '/../items/_cards.php'; ?>
<h2>Active Properties</h2>
<?php $properties = array_values(array_filter($properties, fn($x) => $x['status'] === 'active')); require __DIR__ . '/../properties/_cards.php'; ?>
