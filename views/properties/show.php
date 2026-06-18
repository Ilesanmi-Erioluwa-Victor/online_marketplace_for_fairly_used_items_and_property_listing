<article class="detail">
  <div class="gallery">
    <?php foreach ($images as $img): ?><img src="<?= h($img['image_url']) ?>" alt=""><?php endforeach; ?>
    <?php if (empty($images)): ?><img src="https://placehold.co/800x600?text=Property" alt=""><?php endif; ?>
  </div>
  <div class="detail-content">
    <h1><?= h($property['title']) ?></h1>
    <div class="detail-meta">
      <span class="badge"><?= h($property['listing_type']) ?></span>
      <span class="badge"><?= h($property['property_type']) ?></span>
      <span class="badge badge-<?= $property['status'] === 'active' ? 'success' : ($property['status'] === 'rented' || $property['status'] === 'sold' ? 'danger' : 'warning') ?>"><?= h($property['status']) ?></span>
    </div>
    <div class="detail-price"><?= money($property['price']) ?><?= $property['rent_period'] ? '/' . h($property['rent_period']) : '' ?></div>

    <div class="detail-section">
      <h2>Description</h2>
      <p><?= nl2br(h($property['description'])) ?></p>
    </div>

    <div class="detail-section">
      <h2>Details</h2>
      <div class="stats-grid">
        <div class="stat-box"><strong><?= h($property['bedrooms']) ?></strong><span>Bedrooms</span></div>
        <div class="stat-box"><strong><?= h($property['bathrooms']) ?></strong><span>Bathrooms</span></div>
        <div class="stat-box"><strong><?= h($property['size_sqft']) ?></strong><span>Sq Ft</span></div>
      </div>
    </div>

    <div class="detail-section">
      <h2>Location</h2>
      <p><?= h($property['address']) ?>, <?= h($property['city']) ?>, <?= h($property['state']) ?></p>
    </div>

    <?php $amenitiesList = json_decode($property['amenities'] ?? '[]', true) ?: []; if (!empty($amenitiesList)): ?>
    <div class="detail-section">
      <h2>Amenities</h2>
      <div class="card-tags">
        <?php foreach ($amenitiesList as $a): ?><span class="badge badge-success"><?= h($a) ?></span><?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="detail-section">
      <h2>Landlord / Agent</h2>
      <div class="contact-card">
        <p><strong><a href="/users/<?= h($property['user_id']) ?>"><?= h($property['full_name']) ?></a></strong></p>
        <p><?= h($property['phone']) ?></p>
      </div>
    </div>

    <?php if ($currentUser && (int) $currentUser['id'] !== (int) $property['user_id']): ?>
    <div class="detail-section">
      <h2>Contact Landlord</h2>
      <form method="post" action="/messages/start" class="form-card compact" style="box-shadow:none;padding:0;border:none">
        <?= Csrf::field() ?>
        <input type="hidden" name="listing_table" value="property">
        <input type="hidden" name="listing_id" value="<?= h($property['id']) ?>">
        <div class="form-group">
          <textarea name="body" placeholder="I would like to inspect this property." required style="min-height:80px">I would like to inspect this property.</textarea>
        </div>
        <button type="submit">Send message</button>
      </form>
      <form method="post" action="/properties/<?= h($property['id']) ?>/report" class="form-card compact" style="box-shadow:none;padding:0;border:none;margin-top:12px">
        <?= Csrf::field() ?>
        <div class="form-group">
          <input name="reason" placeholder="Reason" required>
        </div>
        <div class="form-group">
          <textarea name="note" placeholder="Optional note"></textarea>
        </div>
        <button type="submit" class="btn btn-outline btn-sm">Report listing</button>
      </form>
    </div>
    <?php endif; ?>
  </div>
</article>
