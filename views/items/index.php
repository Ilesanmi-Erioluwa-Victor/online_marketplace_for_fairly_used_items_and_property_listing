<h1 style="margin-bottom:20px">Browse Items</h1>
<form class="filters" method="get">
  <input name="q" placeholder="Keyword" value="<?= h($filters['q'] ?? '') ?>">
  <select name="category">
    <option value="">Category</option>
    <?php foreach (['Electronics','Furniture','Vehicles','Fashion','Appliances','Books','Other'] as $c): ?>
      <option <?= ($filters['category'] ?? '') === $c ? 'selected' : '' ?>><?= h($c) ?></option>
    <?php endforeach; ?>
  </select>
  <select name="condition">
    <option value="">Condition</option>
    <?php foreach (['new','like-new','used','fair'] as $c): ?>
      <option <?= ($filters['condition'] ?? '') === $c ? 'selected' : '' ?>><?= h($c) ?></option>
    <?php endforeach; ?>
  </select>
  <input type="number" name="min_price" placeholder="Min price" value="<?= h($filters['min_price'] ?? '') ?>">
  <input type="number" name="max_price" placeholder="Max price" value="<?= h($filters['max_price'] ?? '') ?>">
  <select name="sort">
    <option value="">Newest</option>
    <option value="price_asc" <?= ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Price low to high</option>
    <option value="price_desc" <?= ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Price high to low</option>
  </select>
  <button>Filter</button>
</form>
<?php require __DIR__ . '/_cards.php'; ?>
<?php require __DIR__ . '/../layout/_pagination.php'; ?>
