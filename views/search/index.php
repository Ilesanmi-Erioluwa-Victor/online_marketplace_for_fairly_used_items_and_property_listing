<h1 style="margin-bottom:8px">Search results for &ldquo;<?= h($query) ?>&rdquo;</h1>
<p class="text-muted" style="margin-bottom:20px"><?= count($items) + count($properties) ?> result(s) found</p>

<?php if (!empty($items)): ?>
<section style="margin-bottom:32px">
  <h2 style="margin-bottom:12px">Items</h2>
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
</section>
<?php endif; ?>

<?php if (!empty($properties)): ?>
<section style="margin-bottom:32px">
  <h2 style="margin-bottom:12px">Properties</h2>
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
</section>
<?php endif; ?>

<?php if (empty($items) && empty($properties)): ?>
<div class="empty"><div class="empty-icon">🔍</div><p>No results found for &ldquo;<?= h($query) ?>&rdquo;. Try a different keyword.</p></div>
<?php endif; ?>
