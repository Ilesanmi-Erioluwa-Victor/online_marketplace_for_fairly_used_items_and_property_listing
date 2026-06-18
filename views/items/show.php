<article class="detail">
  <div class="gallery">
    <?php foreach ($images as $img): ?><img src="<?= h($img['image_url']) ?>" alt=""><?php endforeach; ?>
    <?php if (empty($images)): ?><img src="https://placehold.co/800x600?text=Item" alt=""><?php endif; ?>
  </div>
  <div class="detail-content">
    <h1><?= h($item['title']) ?></h1>
    <div class="detail-meta">
      <span class="badge"><?= h($item['category']) ?></span>
      <span class="badge"><?= h($item['condition']) ?></span>
      <span class="badge badge-<?= $item['status'] === 'active' ? 'success' : ($item['status'] === 'sold' ? 'danger' : 'warning') ?>"><?= h($item['status']) ?></span>
    </div>
    <div class="detail-price"><?= money($item['price']) ?></div>

    <div class="detail-section">
      <h2>Description</h2>
      <p><?= nl2br(h($item['description'])) ?></p>
    </div>

    <div class="detail-section">
      <h2>Seller</h2>
      <div class="contact-card">
        <p><strong><a href="/users/<?= h($item['user_id']) ?>"><?= h($item['full_name']) ?></a></strong></p>
        <p><?= h($item['phone']) ?></p>
      </div>
    </div>

    <?php if ($currentUser && (int) $currentUser['id'] !== (int) $item['user_id']): ?>
    <div class="detail-section">
      <h2>Contact Seller</h2>
      <form method="post" action="/messages/start" class="form-card compact" style="box-shadow:none;padding:0;border:none">
        <?= Csrf::field() ?>
        <input type="hidden" name="listing_table" value="item">
        <input type="hidden" name="listing_id" value="<?= h($item['id']) ?>">
        <div class="form-group">
          <textarea name="body" placeholder="Is this still available?" required style="min-height:80px">Is this still available?</textarea>
        </div>
        <button type="submit">Send message</button>
      </form>
      <form method="post" action="/items/<?= h($item['id']) ?>/report" class="form-card compact" style="box-shadow:none;padding:0;border:none;margin-top:12px">
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
