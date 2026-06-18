<div class="form-card wide" style="margin:0 auto">
  <h1>Profile</h1>
  <p class="subtitle">Manage your account details and listings.</p>
  <form method="post" enctype="multipart/form-data">
    <?= Csrf::field() ?>
    <div class="form-row">
      <div class="form-group">
        <label>Full name</label>
        <input name="full_name" value="<?= h($user['full_name']) ?>" required>
      </div>
      <div class="form-group">
        <label>Phone</label>
        <input name="phone" value="<?= h($user['phone']) ?>">
      </div>
    </div>
    <div class="form-group">
      <label>Bio</label>
      <textarea name="bio"><?= h($user['bio']) ?></textarea>
    </div>
    <div class="form-group">
      <label>Profile picture</label>
      <input type="file" name="profile_picture" accept="image/jpeg,image/png,image/webp">
    </div>
    <div class="form-group">
      <label>New password <span class="hint">Leave blank to keep current</span></label>
      <input type="password" name="new_password" minlength="8" placeholder="Leave blank to keep current">
    </div>
    <button type="submit">Update profile</button>
  </form>
</div>

<section>
  <h2>My Item Listings</h2>
  <div class="list">
  <?php foreach ($items as $listing): ?>
    <div class="listing-row">
      <div class="listing-row-info">
        <a href="/items/<?= h($listing['id']) ?>"><strong><?= h($listing['title']) ?></strong></a>
        <div class="meta"><span class="badge badge-<?= $listing['status'] === 'active' ? 'success' : ($listing['status'] === 'sold' ? 'danger' : 'warning') ?>"><?= h($listing['status']) ?></span> · <?= money($listing['price']) ?></div>
      </div>
      <div class="listing-row-actions">
        <a class="btn btn-sm btn-outline" href="/items/<?= h($listing['id']) ?>/edit">Edit</a>
        <?php if ($listing['status'] === 'active'): ?>
        <form method="post" action="/feature" class="inline-form">
          <?= Csrf::field() ?><input type="hidden" name="listing_table" value="item"><input type="hidden" name="listing_id" value="<?= h($listing['id']) ?>"><button class="btn-sm btn-primary">Feature ₦<?= number_format($config['item_feature_fee']) ?></button>
        </form>
        <?php endif; ?>
        <form method="post" action="/items/<?= h($listing['id']) ?>/delete" class="inline-form">
          <?= Csrf::field() ?><button class="btn-sm btn-danger">Remove</button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</section>

<section>
  <h2>My Property Listings</h2>
  <div class="list">
  <?php foreach ($properties as $listing): ?>
    <div class="listing-row">
      <div class="listing-row-info">
        <a href="/properties/<?= h($listing['id']) ?>"><strong><?= h($listing['title']) ?></strong></a>
        <div class="meta"><span class="badge badge-<?= $listing['status'] === 'active' ? 'success' : ($listing['status'] === 'rented' || $listing['status'] === 'sold' ? 'danger' : 'warning') ?>"><?= h($listing['status']) ?></span> · <?= money($listing['price']) ?></div>
      </div>
      <div class="listing-row-actions">
        <a class="btn btn-sm btn-outline" href="/properties/<?= h($listing['id']) ?>/edit">Edit</a>
        <?php if ($listing['status'] === 'active'): ?>
        <form method="post" action="/feature" class="inline-form">
          <?= Csrf::field() ?><input type="hidden" name="listing_table" value="property"><input type="hidden" name="listing_id" value="<?= h($listing['id']) ?>"><button class="btn-sm btn-primary">Feature ₦<?= number_format($config['property_feature_fee']) ?></button>
        </form>
        <?php endif; ?>
        <form method="post" action="/properties/<?= h($listing['id']) ?>/delete" class="inline-form">
          <?= Csrf::field() ?><button class="btn-sm btn-danger">Remove</button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</section>
