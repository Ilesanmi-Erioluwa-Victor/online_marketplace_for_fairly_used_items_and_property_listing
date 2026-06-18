<div class="profile-header">
  <?php if ($publicUser['profile_picture_url']): ?><img class="profile-avatar" src="<?= h($publicUser['profile_picture_url']) ?>" alt=""><?php endif; ?>
  <div class="profile-info">
    <h1><?= h($publicUser['full_name']) ?></h1>
    <p><?= nl2br(h($publicUser['bio'] ?? '')) ?></p>
    <p class="joined"><?= h($publicUser['phone'] ?? '') ?> · Joined <?= h(date('M j, Y', strtotime($publicUser['created_at']))) ?></p>
  </div>
</div>

<section>
  <h2>Active Items</h2>
  <?php $items = array_values(array_filter($items, fn($x) => $x['status'] === 'active')); require __DIR__ . '/../items/_cards.php'; ?>
</section>

<section>
  <h2>Active Properties</h2>
  <?php $properties = array_values(array_filter($properties, fn($x) => $x['status'] === 'active')); require __DIR__ . '/../properties/_cards.php'; ?>
</section>
