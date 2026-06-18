<?php if (empty($properties)): ?>
  <div class="empty"><div class="empty-icon">🏠</div><p>No properties found. Try broadening your search.</p></div>
<?php else: ?>
<div class="grid cards">
<?php foreach ($properties as $property): ?>
  <a class="card" href="/properties/<?= h($property['id']) ?>">
    <img class="card-img" src="<?= h($property['image_url'] ?? 'https://placehold.co/800x600?text=Property') ?>" alt="">
    <div class="card-body">
      <div class="card-tags">
        <span class="badge"><?= h($property['listing_type']) ?></span>
        <?php if (!empty($property['is_featured'])): ?><span class="badge badge-accent">Featured</span><?php endif; ?>
      </div>
      <h3><?= h($property['title']) ?></h3>
      <p class="text-muted"><?= h($property['city']) ?>, <?= h($property['state']) ?></p>
      <p class="price"><?= money($property['price']) ?><?= $property['rent_period'] ? '/' . h($property['rent_period']) : '' ?></p>
    </div>
  </a>
<?php endforeach; ?>
</div>
<?php endif; ?>
