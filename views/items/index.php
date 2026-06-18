<h1>Browse Items</h1>
<form class="filters" method="get">
  <input name="q" placeholder="Keyword" value="<?= h($filters['q'] ?? '') ?>">
  <select name="category"><option value="">Category</option><?php foreach (['Electronics','Furniture','Vehicles','Fashion','Appliances','Books','Other'] as $c): ?><option <?= ($filters['category'] ?? '') === $c ? 'selected' : '' ?>><?= h($c) ?></option><?php endforeach; ?></select>
  <select name="condition"><option value="">Condition</option><?php foreach (['new','like-new','used','fair'] as $c): ?><option <?= ($filters['condition'] ?? '') === $c ? 'selected' : '' ?>><?= h($c) ?></option><?php endforeach; ?></select>
  <input type="number" name="min_price" placeholder="Min price" value="<?= h($filters['min_price'] ?? '') ?>">
  <input type="number" name="max_price" placeholder="Max price" value="<?= h($filters['max_price'] ?? '') ?>">
  <select name="sort"><option value="">Newest</option><option value="price_asc">Price low to high</option><option value="price_desc">Price high to low</option></select>
  <button>Filter</button>
</form>
<?php require __DIR__ . '/_cards.php'; ?>
