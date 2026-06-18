<h1 style="margin-bottom:20px">Browse Properties</h1>
<form class="filters" method="get">
  <input name="q" placeholder="Keyword" value="<?= h($filters['q'] ?? '') ?>">
  <select name="listing_type">
    <option value="">Rent/Sale</option>
    <option value="rent" <?= ($filters['listing_type'] ?? '') === 'rent' ? 'selected' : '' ?>>Rent</option>
    <option value="sale" <?= ($filters['listing_type'] ?? '') === 'sale' ? 'selected' : '' ?>>Sale</option>
  </select>
  <select name="property_type">
    <option value="">Type</option>
    <?php foreach (['apartment','house','duplex','self-contain','land','commercial'] as $c): ?>
      <option value="<?= h($c) ?>" <?= ($filters['property_type'] ?? '') === $c ? 'selected' : '' ?>><?= h($c) ?></option>
    <?php endforeach; ?>
  </select>
  <input name="city" placeholder="City" value="<?= h($filters['city'] ?? '') ?>">
  <input name="state" placeholder="State" value="<?= h($filters['state'] ?? '') ?>">
  <input type="number" name="min_price" placeholder="Min price" value="<?= h($filters['min_price'] ?? '') ?>">
  <input type="number" name="max_price" placeholder="Max price" value="<?= h($filters['max_price'] ?? '') ?>">
  <input type="number" name="bedrooms" placeholder="Bedrooms" value="<?= h($filters['bedrooms'] ?? '') ?>">
  <select name="sort">
    <option value="">Newest</option>
    <option value="price_asc" <?= ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Price low to high</option>
    <option value="price_desc" <?= ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Price high to low</option>
  </select>
  <button>Filter</button>
</form>
<?php require __DIR__ . '/_cards.php'; ?>
