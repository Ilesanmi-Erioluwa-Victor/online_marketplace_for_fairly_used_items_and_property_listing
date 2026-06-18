<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-content">
    <h1>Find what you need. Sell what you don't.</h1>
    <p>Discover fairly used items and verified property listings from real people.</p>
    <form class="searchbar" action="/search" method="get">
      <input name="q" value="<?= h($query ?? '') ?>" placeholder="Search phones, furniture, apartments, land...">
      <button type="submit">Search</button>
    </form>
  </div>
</section>

<?php if (!empty($featured)): ?>
<section>
  <div class="section-header">
    <h2>Featured Listings</h2>
  </div>
  <div class="grid cards">
  <?php foreach ($featured as $listing): ?>
    <a class="card" href="/<?= $listing['listing_table'] === 'item' ? 'items' : 'properties' ?>/<?= h($listing['listing_id']) ?>">
      <img class="card-img" src="<?= h($listing['image_url'] ?: 'https://placehold.co/800x600?text=Featured') ?>" alt="">
      <div class="card-body">
        <div class="card-tags"><span class="badge badge-accent">Featured</span></div>
        <h3><?= h($listing['title']) ?></h3>
      </div>
    </a>
  <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($itemsElectronics)): ?>
<section>
  <div class="section-header">
    <h2>Electronics</h2>
    <a href="/items?category=Electronics">View all &rarr;</a>
  </div>
  <div class="grid cards">
  <?php foreach ($itemsElectronics as $item): ?>
    <a class="card" href="/items/<?= h($item['id']) ?>">
      <img class="card-img" src="<?= h($item['image_url'] ?? 'https://placehold.co/800x600?text=Item') ?>" alt="">
      <div class="card-body">
        <div class="card-tags"><span class="badge"><?= h($item['condition']) ?></span></div>
        <h3><?= h($item['title']) ?></h3>
        <p class="text-muted"><?= h($item['category']) ?><?php if (!empty($item['city']) || !empty($item['state'])): ?> · 📍 <?= h($item['city'] ?? '') ?><?= (!empty($item['city']) && !empty($item['state'])) ? ', ' : '' ?><?= h($item['state'] ?? '') ?><?php endif; ?></p>
        <p class="price"><?= money($item['price']) ?></p>
      </div>
    </a>
  <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($itemsFurniture)): ?>
<section>
  <div class="section-header">
    <h2>Furniture</h2>
    <a href="/items?category=Furniture">View all &rarr;</a>
  </div>
  <div class="grid cards">
  <?php foreach ($itemsFurniture as $item): ?>
    <a class="card" href="/items/<?= h($item['id']) ?>">
      <img class="card-img" src="<?= h($item['image_url'] ?? 'https://placehold.co/800x600?text=Item') ?>" alt="">
      <div class="card-body">
        <div class="card-tags"><span class="badge"><?= h($item['condition']) ?></span></div>
        <h3><?= h($item['title']) ?></h3>
        <p class="text-muted"><?= h($item['category']) ?><?php if (!empty($item['city']) || !empty($item['state'])): ?> · 📍 <?= h($item['city'] ?? '') ?><?= (!empty($item['city']) && !empty($item['state'])) ? ', ' : '' ?><?= h($item['state'] ?? '') ?><?php endif; ?></p>
        <p class="price"><?= money($item['price']) ?></p>
      </div>
    </a>
  <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($itemsAppliances)): ?>
<section>
  <div class="section-header">
    <h2>Appliances</h2>
    <a href="/items?category=Appliances">View all &rarr;</a>
  </div>
  <div class="grid cards">
  <?php foreach ($itemsAppliances as $item): ?>
    <a class="card" href="/items/<?= h($item['id']) ?>">
      <img class="card-img" src="<?= h($item['image_url'] ?? 'https://placehold.co/800x600?text=Item') ?>" alt="">
      <div class="card-body">
        <div class="card-tags"><span class="badge"><?= h($item['condition']) ?></span></div>
        <h3><?= h($item['title']) ?></h3>
        <p class="text-muted"><?= h($item['category']) ?><?php if (!empty($item['city']) || !empty($item['state'])): ?> · 📍 <?= h($item['city'] ?? '') ?><?= (!empty($item['city']) && !empty($item['state'])) ? ', ' : '' ?><?= h($item['state'] ?? '') ?><?php endif; ?></p>
        <p class="price"><?= money($item['price']) ?></p>
      </div>
    </a>
  <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($itemsFashion)): ?>
<section>
  <div class="section-header">
    <h2>Fashion</h2>
    <a href="/items?category=Fashion">View all &rarr;</a>
  </div>
  <div class="grid cards">
  <?php foreach ($itemsFashion as $item): ?>
    <a class="card" href="/items/<?= h($item['id']) ?>">
      <img class="card-img" src="<?= h($item['image_url'] ?? 'https://placehold.co/800x600?text=Item') ?>" alt="">
      <div class="card-body">
        <div class="card-tags"><span class="badge"><?= h($item['condition']) ?></span></div>
        <h3><?= h($item['title']) ?></h3>
        <p class="text-muted"><?= h($item['category']) ?><?php if (!empty($item['city']) || !empty($item['state'])): ?> · 📍 <?= h($item['city'] ?? '') ?><?= (!empty($item['city']) && !empty($item['state'])) ? ', ' : '' ?><?= h($item['state'] ?? '') ?><?php endif; ?></p>
        <p class="price"><?= money($item['price']) ?></p>
      </div>
    </a>
  <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($propertiesRent)): ?>
<section>
  <div class="section-header">
    <h2>Properties for Rent</h2>
    <a href="/properties?listing_type=rent">View all &rarr;</a>
  </div>
  <div class="grid cards">
  <?php foreach ($propertiesRent as $property): ?>
    <a class="card" href="/properties/<?= h($property['id']) ?>">
      <img class="card-img" src="<?= h($property['image_url'] ?? 'https://placehold.co/800x600?text=Property') ?>" alt="">
      <div class="card-body">
        <div class="card-tags"><span class="badge"><?= h($property['property_type']) ?></span></div>
        <h3><?= h($property['title']) ?></h3>
        <p class="text-muted"><?= h($property['city']) ?>, <?= h($property['state']) ?> — <?= h($property['bedrooms']) ?> bed</p>
        <p class="price"><?= money($property['price']) ?>/yr</p>
      </div>
    </a>
  <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($propertiesSale)): ?>
<section>
  <div class="section-header">
    <h2>Properties for Sale</h2>
    <a href="/properties?listing_type=sale">View all &rarr;</a>
  </div>
  <div class="grid cards">
  <?php foreach ($propertiesSale as $property): ?>
    <a class="card" href="/properties/<?= h($property['id']) ?>">
      <img class="card-img" src="<?= h($property['image_url'] ?? 'https://placehold.co/800x600?text=Property') ?>" alt="">
      <div class="card-body">
        <div class="card-tags"><span class="badge"><?= h($property['property_type']) ?></span></div>
        <h3><?= h($property['title']) ?></h3>
        <p class="text-muted"><?= h($property['city']) ?>, <?= h($property['state']) ?> — <?= h($property['bedrooms']) ?> bed</p>
        <p class="price"><?= money($property['price']) ?></p>
      </div>
    </a>
  <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<section>
  <div class="section-header">
    <h2>Recent Items</h2>
    <a href="/items">View all &rarr;</a>
  </div>
  <div class="grid cards">
  <?php foreach ($itemsRecently as $item): ?>
    <a class="card" href="/items/<?= h($item['id']) ?>">
      <img class="card-img" src="<?= h($item['image_url'] ?? 'https://placehold.co/800x600?text=Item') ?>" alt="">
      <div class="card-body">
        <div class="card-tags"><span class="badge"><?= h($item['category']) ?></span></div>
        <h3><?= h($item['title']) ?></h3>
        <p class="text-muted"><?= h($item['condition']) ?><?php if (!empty($item['city']) || !empty($item['state'])): ?> · 📍 <?= h($item['city'] ?? '') ?><?= (!empty($item['city']) && !empty($item['state'])) ? ', ' : '' ?><?= h($item['state'] ?? '') ?><?php endif; ?></p>
        <p class="price"><?= money($item['price']) ?></p>
      </div>
    </a>
  <?php endforeach; ?>
  </div>
</section>

<section>
  <div class="section-header">
    <h2>Recent Properties</h2>
    <a href="/properties">View all &rarr;</a>
  </div>
  <div class="grid cards">
  <?php foreach ($propertiesRecently as $property): ?>
    <a class="card" href="/properties/<?= h($property['id']) ?>">
      <img class="card-img" src="<?= h($property['image_url'] ?? 'https://placehold.co/800x600?text=Property') ?>" alt="">
      <div class="card-body">
        <div class="card-tags"><span class="badge"><?= h($property['listing_type']) ?></span></div>
        <h3><?= h($property['title']) ?></h3>
        <p class="text-muted"><?= h($property['city']) ?>, <?= h($property['state']) ?></p>
        <p class="price"><?= money($property['price']) ?><?= $property['rent_period'] ? '/' . h($property['rent_period']) : '' ?></p>
      </div>
    </a>
  <?php endforeach; ?>
  </div>
</section>
