<?php $amenities = is_array($property['amenities'] ?? null) ? $property['amenities'] : json_decode($property['amenities'] ?? '[]', true); ?>
<form method="post" enctype="multipart/form-data" class="form" data-validate>
  <?= Csrf::field() ?>
  <label>Title <input name="title" value="<?= h($property['title']) ?>" required></label>
  <label>Description <textarea name="description" required><?= h($property['description']) ?></textarea></label>
  <label>Listing type <select name="listing_type"><option value="rent" <?= $property['listing_type']==='rent'?'selected':'' ?>>Rent</option><option value="sale" <?= $property['listing_type']==='sale'?'selected':'' ?>>Sale</option></select></label>
  <label>Property type <select name="property_type"><?php foreach (['apartment','house','duplex','self-contain','land','commercial'] as $c): ?><option value="<?= h($c) ?>" <?= $property['property_type']===$c?'selected':'' ?>><?= h($c) ?></option><?php endforeach; ?></select></label>
  <label>Price <input type="number" name="price" min="0" value="<?= h($property['price']) ?>" required></label>
  <label>Rent period <select name="rent_period"><option value="">Not rent</option><option value="monthly" <?= $property['rent_period']==='monthly'?'selected':'' ?>>Monthly</option><option value="yearly" <?= $property['rent_period']==='yearly'?'selected':'' ?>>Yearly</option></select></label>
  <label>Bedrooms <input type="number" name="bedrooms" min="0" value="<?= h($property['bedrooms']) ?>"></label>
  <label>Bathrooms <input type="number" name="bathrooms" min="0" value="<?= h($property['bathrooms']) ?>"></label>
  <label>Size sqft <input type="number" name="size_sqft" min="0" value="<?= h($property['size_sqft']) ?>"></label>
  <label>Address <textarea name="address" required><?= h($property['address']) ?></textarea></label>
  <label>City <input name="city" value="<?= h($property['city']) ?>" required></label>
  <label>State <input name="state" value="<?= h($property['state']) ?>" required></label>
  <fieldset><legend>Amenities</legend><?php foreach (['Parking','Water','Electricity','Furnished'] as $a): ?><label class="check"><input type="checkbox" name="amenities[]" value="<?= h($a) ?>" <?= in_array($a, $amenities ?: [], true) ? 'checked' : '' ?>> <?= h($a) ?></label><?php endforeach; ?></fieldset>
  <?php if (!empty($property['id'])): ?><label>Status <select name="status"><?php foreach (['pending','active','rented','sold','removed'] as $s): ?><option <?= $property['status'] === $s ? 'selected' : '' ?>><?= h($s) ?></option><?php endforeach; ?></select></label><?php else: ?><input type="hidden" name="status" value="pending"><?php endif; ?>
  <label>Images <input type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple data-preview></label>
  <div class="preview"></div>
  <button type="submit">Save property</button>
</form>
