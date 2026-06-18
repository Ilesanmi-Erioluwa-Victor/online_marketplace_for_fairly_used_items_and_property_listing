<?php if (empty($properties)): ?>
  <p class="empty">No results found. Try broadening your search.</p>
<?php else: ?>
<div class="grid cards">
<?php foreach ($properties as $property): ?>
  <a class="card" href="/properties/<?= h($property['id']) ?>">
    <img src="<?= h($property['image_url'] ?? 'https://placehold.co/800x600?text=Property') ?>" alt="">
    <div class="card-row"><span class="badge"><?= h($property['listing_type']) ?></span><?php if (!empty($property['is_featured'])): ?><span class="badge accent">Featured</span><?php endif; ?></div>
    <h3><?= h($property['title']) ?></h3>
    <p class="price"><?= money($property['price']) ?><?= $property['rent_period'] ? '/' . h($property['rent_period']) : '' ?></p>
    <p><?= h($property['city']) ?>, <?= h($property['state']) ?></p>
  </a>
<?php endforeach; ?>
</div>
<?php endif; ?>
