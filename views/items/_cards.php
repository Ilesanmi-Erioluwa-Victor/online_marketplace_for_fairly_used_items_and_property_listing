<?php if (empty($items)): ?>
  <p class="empty">No results found. Try broadening your search.</p>
<?php else: ?>
<div class="grid cards">
<?php foreach ($items as $item): ?>
  <a class="card" href="/items/<?= h($item['id']) ?>">
    <img src="<?= h($item['image_url'] ?? 'https://placehold.co/800x600?text=Item') ?>" alt="">
    <div class="card-row"><span class="badge"><?= h($item['category']) ?></span><?php if (!empty($item['is_featured'])): ?><span class="badge accent">Featured</span><?php endif; ?></div>
    <h3><?= h($item['title']) ?></h3>
    <p class="price"><?= money($item['price']) ?></p>
    <p><?= h($item['condition']) ?> · <?= h($item['full_name'] ?? '') ?></p>
  </a>
<?php endforeach; ?>
</div>
<?php endif; ?>
