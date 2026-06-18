<?php $amenities = is_array($property['amenities'] ?? null) ? $property['amenities'] : json_decode($property['amenities'] ?? '[]', true); ?>
<form method="post" enctype="multipart/form-data" class="form-card wide" data-validate action="<?= !empty($property['id']) ? '' : '/properties' ?>">
  <?= Csrf::field() ?>
  <h1 style="margin:0 0 4px"><?= !empty($property['id']) ? 'Edit Property' : 'Post Property' ?></h1>
  <p class="subtitle"><?= !empty($property['id']) ? 'Update your listing details.' : 'List your property for rent or sale.' ?></p>
  <div class="form-group">
    <label>Title</label>
    <input name="title" value="<?= h($property['title']) ?>" required>
  </div>
  <div class="form-group">
    <label>Description</label>
    <textarea name="description" required><?= h($property['description']) ?></textarea>
  </div>
  <div class="form-row">
    <div class="form-group">
      <label>Listing type</label>
      <select name="listing_type">
        <option value="rent" <?= $property['listing_type']==='rent'?'selected':'' ?>>Rent</option>
        <option value="sale" <?= $property['listing_type']==='sale'?'selected':'' ?>>Sale</option>
      </select>
    </div>
    <div class="form-group">
      <label>Property type</label>
      <select name="property_type">
        <?php foreach (['apartment','house','duplex','self-contain','land','commercial'] as $c): ?>
          <option value="<?= h($c) ?>" <?= $property['property_type']===$c?'selected':'' ?>><?= h($c) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group">
      <label>Price (₦)</label>
      <input type="number" name="price" min="0" value="<?= h($property['price']) ?>" required>
    </div>
    <div class="form-group">
      <label>Rent period</label>
      <select name="rent_period">
        <option value="">Not for rent</option>
        <option value="monthly" <?= $property['rent_period']==='monthly'?'selected':'' ?>>Monthly</option>
        <option value="yearly" <?= $property['rent_period']==='yearly'?'selected':'' ?>>Yearly</option>
      </select>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group">
      <label>Bedrooms</label>
      <input type="number" name="bedrooms" min="0" value="<?= h($property['bedrooms']) ?>">
    </div>
    <div class="form-group">
      <label>Bathrooms</label>
      <input type="number" name="bathrooms" min="0" value="<?= h($property['bathrooms']) ?>">
    </div>
    <div class="form-group">
      <label>Size (sqft)</label>
      <input type="number" name="size_sqft" min="0" value="<?= h($property['size_sqft']) ?>">
    </div>
  </div>
  <div class="form-group">
    <label>Address</label>
    <textarea name="address" required><?= h($property['address']) ?></textarea>
  </div>
  <div class="form-row">
    <div class="form-group">
      <label>City</label>
      <input name="city" value="<?= h($property['city']) ?>" required>
    </div>
    <div class="form-group">
      <label>State</label>
      <input name="state" value="<?= h($property['state']) ?>" required>
    </div>
  </div>
  <div class="form-group">
    <fieldset>
      <legend>Amenities</legend>
      <div class="check-group">
        <?php foreach (['Parking','Water','Electricity','Furnished'] as $a): ?>
          <label class="check-label">
            <input type="checkbox" name="amenities[]" value="<?= h($a) ?>" <?= in_array($a, $amenities ?: [], true) ? 'checked' : '' ?>>
            <?= h($a) ?>
          </label>
        <?php endforeach; ?>
      </div>
    </fieldset>
  </div>
  <?php if (!empty($property['id'])): ?>
  <div class="form-group">
    <label>Status</label>
    <select name="status">
      <?php foreach (['pending','active','rented','sold','removed'] as $s): ?>
        <option <?= $property['status'] === $s ? 'selected' : '' ?>><?= h($s) ?></option>
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
    <button type="submit"><?= !empty($property['id']) ? 'Update property' : 'Post property' ?></button>
    <a href="<?= !empty($property['id']) ? '/properties/' . h($property['id']) : '/properties' ?>" class="btn btn-outline">Cancel</a>
  </div>
</form>
