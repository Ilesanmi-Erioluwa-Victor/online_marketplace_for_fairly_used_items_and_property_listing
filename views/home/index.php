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

<div class="split">
  <section>
    <div class="section-header">
      <h2>Recent Items</h2>
      <a href="/items">View all &rarr;</a>
    </div>
    <?php $items = $items ?? []; require __DIR__ . '/../items/_cards.php'; ?>
  </section>
  <section>
    <div class="section-header">
      <h2>Recent Properties</h2>
      <a href="/properties">View all &rarr;</a>
    </div>
    <?php $properties = $properties ?? []; require __DIR__ . '/../properties/_cards.php'; ?>
  </section>
</div>
