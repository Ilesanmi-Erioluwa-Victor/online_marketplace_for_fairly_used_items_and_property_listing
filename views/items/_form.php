<form method="post" enctype="multipart/form-data" class="form-card wide" data-validate action="<?= !empty($item['id']) ? '' : '/items' ?>">
  <?= Csrf::field() ?>
  <h1 style="margin:0 0 4px"><?= !empty($item['id']) ? 'Edit Item' : 'Post Item' ?></h1>
  <p class="subtitle"><?= !empty($item['id']) ? 'Update your listing details.' : 'Describe your item for potential buyers.' ?></p>
  <div class="form-group">
    <label>Title</label>
    <input name="title" value="<?= h($item['title']) ?>" required>
  </div>
  <div class="form-group">
    <label>Description</label>
    <textarea name="description" required><?= h($item['description']) ?></textarea>
  </div>
  <div class="form-row">
    <div class="form-group">
      <label>Category</label>
      <select name="category">
        <?php foreach (['Electronics','Furniture','Vehicles','Fashion','Appliances','Books','Other'] as $c): ?>
          <option <?= $item['category'] === $c ? 'selected' : '' ?>><?= h($c) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Condition</label>
      <select name="condition">
        <?php foreach (['new','like-new','used','fair'] as $c): ?>
          <option value="<?= h($c) ?>" <?= $item['condition'] === $c ? 'selected' : '' ?>><?= h($c) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group">
      <label>City</label>
      <input name="city" value="<?= h($item['city'] ?? '') ?>" placeholder="e.g. Ikeja">
    </div>
    <div class="form-group">
      <label>State</label>
      <input name="state" value="<?= h($item['state'] ?? '') ?>" placeholder="e.g. Lagos">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group">
      <label>Price (₦)</label>
      <input type="number" name="price" min="0" value="<?= h($item['price']) ?>" required>
    </div>
    <div class="form-group">
      <label>Quantity</label>
      <input type="number" name="quantity" min="0" value="<?= h($item['quantity']) ?>" required>
    </div>
  </div>
  <?php if (!empty($item['id'])): ?>
  <div class="form-group">
    <label>Status</label>
    <select name="status">
      <?php foreach (['pending','active','sold','removed'] as $s): ?>
        <option <?= $item['status'] === $s ? 'selected' : '' ?>><?= h($s) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <?php else: ?>
    <input type="hidden" name="status" value="pending">
  <?php endif; ?>
  <div class="form-group">
    <label>Images</label>
    <input type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple data-preview>
    <div class="preview"></div>
  </div>
  <div class="form-actions">
    <button type="submit"><?= !empty($item['id']) ? 'Update item' : 'Post item' ?></button>
    <a href="<?= !empty($item['id']) ? '/items/' . h($item['id']) : '/items' ?>" class="btn btn-outline">Cancel</a>
  </div>
</form>
