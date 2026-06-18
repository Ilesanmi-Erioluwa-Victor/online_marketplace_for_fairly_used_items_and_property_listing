<h1>Profile</h1>
<form method="post" enctype="multipart/form-data" class="form">
  <?= Csrf::field() ?>
  <label>Full name <input name="full_name" value="<?= h($user['full_name']) ?>" required></label>
  <label>Phone <input name="phone" value="<?= h($user['phone']) ?>"></label>
  <label>Bio <textarea name="bio"><?= h($user['bio']) ?></textarea></label>
  <label>Profile picture <input type="file" name="profile_picture" accept="image/jpeg,image/png,image/webp"></label>
  <label>New password <input type="password" name="new_password" minlength="8" placeholder="Leave blank to keep current password"></label>
  <button>Update profile</button>
</form>

<h2>My Item Listings</h2>
<div class="list">
<?php foreach ($items as $listing): ?>
  <div class="row">
    <a href="/items/<?= h($listing['id']) ?>"><strong><?= h($listing['title']) ?></strong></a>
    <span><?= h($listing['status']) ?> · <?= money($listing['price']) ?></span>
    <div class="actions">
      <a class="button small" href="/items/<?= h($listing['id']) ?>/edit">Edit</a>
      <?php if ($listing['status'] === 'active'): ?><form method="post" action="/feature" class="inline"><?= Csrf::field() ?><input type="hidden" name="listing_table" value="item"><input type="hidden" name="listing_id" value="<?= h($listing['id']) ?>"><button class="small">Feature ₦<?= number_format($config['item_feature_fee']) ?></button></form><?php endif; ?>
      <form method="post" action="/items/<?= h($listing['id']) ?>/delete" class="inline"><?= Csrf::field() ?><button class="secondary small">Remove</button></form>
    </div>
  </div>
<?php endforeach; ?>
</div>

<h2>My Property Listings</h2>
<div class="list">
<?php foreach ($properties as $listing): ?>
  <div class="row">
    <a href="/properties/<?= h($listing['id']) ?>"><strong><?= h($listing['title']) ?></strong></a>
    <span><?= h($listing['status']) ?> · <?= money($listing['price']) ?></span>
    <div class="actions">
      <a class="button small" href="/properties/<?= h($listing['id']) ?>/edit">Edit</a>
      <?php if ($listing['status'] === 'active'): ?><form method="post" action="/feature" class="inline"><?= Csrf::field() ?><input type="hidden" name="listing_table" value="property"><input type="hidden" name="listing_id" value="<?= h($listing['id']) ?>"><button class="small">Feature ₦<?= number_format($config['property_feature_fee']) ?></button></form><?php endif; ?>
      <form method="post" action="/properties/<?= h($listing['id']) ?>/delete" class="inline"><?= Csrf::field() ?><button class="secondary small">Remove</button></form>
    </div>
  </div>
<?php endforeach; ?>
</div>
