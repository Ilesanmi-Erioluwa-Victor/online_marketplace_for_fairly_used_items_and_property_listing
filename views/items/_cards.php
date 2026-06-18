<?php if (empty($items)): ?>
  <div class="empty"><div class="empty-icon">📦</div><p>No items found. Try broadening your search.</p></div>
<?php else: ?>
<div class="grid cards">
<?php foreach ($items as $item): ?>
  <a class="card" href="/items/<?= h($item['id']) ?>">
    <img class="card-img" src="<?= h($item['image_url'] ?? 'https://placehold.co/800x600?text=Item') ?>" alt="">
    <div class="card-body">
      <div class="card-tags">
        <span class="badge"><?= h($item['category']) ?></span>
        <?php if (!empty($item['is_featured'])): ?><span class="badge badge-accent">Featured</span><?php endif; ?>
      </div>
      <h3><?= h($item['title']) ?></h3>
      <p class="text-muted"><?= h($item['condition']) ?><?php if (!empty($item['city']) || !empty($item['state'])): ?> · 📍 <?= h($item['city'] ?? '') ?><?= (!empty($item['city']) && !empty($item['state'])) ? ', ' : '' ?><?= h($item['state'] ?? '') ?><?php endif; ?></p>
      <p class="price"><?= money($item['price']) ?></p>
    </div>
  </a>
<?php endforeach; ?>
</div>
<?php endif; ?>
