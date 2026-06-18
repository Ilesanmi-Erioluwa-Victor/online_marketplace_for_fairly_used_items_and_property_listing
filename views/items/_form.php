<form method="post" enctype="multipart/form-data" class="form" data-validate>
  <?= Csrf::field() ?>
  <label>Title <input name="title" value="<?= h($item['title']) ?>" required></label>
  <label>Description <textarea name="description" required><?= h($item['description']) ?></textarea></label>
  <label>Category <select name="category"><?php foreach (['Electronics','Furniture','Vehicles','Fashion','Appliances','Books','Other'] as $c): ?><option <?= $item['category'] === $c ? 'selected' : '' ?>><?= h($c) ?></option><?php endforeach; ?></select></label>
  <label>Condition <select name="condition"><?php foreach (['new','like-new','used','fair'] as $c): ?><option value="<?= h($c) ?>" <?= $item['condition'] === $c ? 'selected' : '' ?>><?= h($c) ?></option><?php endforeach; ?></select></label>
  <label>Price <input type="number" name="price" min="0" value="<?= h($item['price']) ?>" required></label>
  <label>Quantity <input type="number" name="quantity" min="0" value="<?= h($item['quantity']) ?>" required></label>
  <?php if (!empty($item['id'])): ?><label>Status <select name="status"><?php foreach (['pending','active','sold','removed'] as $s): ?><option <?= $item['status'] === $s ? 'selected' : '' ?>><?= h($s) ?></option><?php endforeach; ?></select></label><?php else: ?><input type="hidden" name="status" value="pending"><?php endif; ?>
  <label>Images <input type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple data-preview></label>
  <div class="preview"></div>
  <button type="submit">Save item</button>
</form>
