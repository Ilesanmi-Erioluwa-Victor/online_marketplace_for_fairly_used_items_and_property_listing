<section class="hero">
  <div>
    <h1>Find fairly used items and verified property listings</h1>
    <form class="searchbar" action="/search" method="get">
      <input name="q" value="<?= h($query ?? '') ?>" placeholder="Search phones, furniture, Lekki flats, Abuja land">
      <button type="submit">Search</button>
    </form>
  </div>
</section>

<?php if (!empty($featured)): ?>
<h2>Featured Listings</h2>
<div class="grid cards">
<?php foreach ($featured as $listing): ?>
  <a class="card" href="/<?= $listing['listing_table'] === 'item' ? 'items' : 'properties' ?>/<?= h($listing['listing_id']) ?>">
    <img src="<?= h($listing['image_url'] ?: 'https://placehold.co/800x600?text=Featured') ?>" alt="">
    <span class="badge accent">Featured</span>
    <h3><?= h($listing['title']) ?></h3>
  </a>
<?php endforeach; ?>
</div>
<?php endif; ?>

<div class="split">
  <section>
    <h2>Recently Added Items</h2>
    <?php $items = $items ?? []; require __DIR__ . '/../items/_cards.php'; ?>
  </section>
  <section>
    <h2>Recently Added Properties</h2>
    <?php $properties = $properties ?? []; require __DIR__ . '/../properties/_cards.php'; ?>
  </section>
</div>
