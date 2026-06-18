<h1 style="margin-bottom:24px">Pending Listings</h1>
<div class="admin-nav">
  <a href="/admin">Dashboard</a>
  <a href="/admin/users">Users</a>
  <a href="/admin/reports">Reports</a>
  <a href="/admin/analytics">Analytics</a>
</div>

<?php foreach ([['label'=>'Items', 'rows'=>$items, 'route'=>'items'], ['label'=>'Properties', 'rows'=>$properties, 'route'=>'properties']] as $section): ?>
<section style="margin-bottom:32px">
  <h2 style="margin-bottom:16px"><?= h($section['label']) ?> <span class="badge badge-warning"><?= count($section['rows']) ?> pending</span></h2>

  <?php if (empty($section['rows'])): ?>
    <div class="empty"><div class="empty-icon">✅</div><p>No pending <?= strtolower($section['label']) ?> to review.</p></div>
  <?php else: ?>
  <div class="listing-cards">
  <?php foreach ($section['rows'] as $row): ?>
    <div class="listing-card">
      <div class="listing-card-img">
        <img src="<?= h($row['image_url'] ?? 'https://placehold.co/800x600?text=No+Image') ?>" alt="">
      </div>
      <div class="listing-card-body">
        <div class="listing-card-header">
          <a href="/<?= $section['route'] ?>/<?= h($row['id']) ?>" class="listing-card-title" target="_blank"><?= h($row['title']) ?></a>
          <div class="listing-card-price"><?= money($row['price']) ?><?= !empty($row['rent_period']) ? '/' . h($row['rent_period']) : '' ?></div>
        </div>
        <p class="listing-card-desc"><?= h(mb_strimwidth(strip_tags($row['description']), 0, 200, '...')) ?></p>
        <div class="listing-card-meta">
          <span>by <?= h($row['user_name'] ?? 'Unknown') ?></span>
          <span><?= $section['route'] === 'items' ? h($row['category'] ?? '') : h($row['property_type'] ?? '') . ' · ' . h($row['city'] ?? '') ?></span>
          <span><?= date('M j, Y', strtotime($row['created_at'])) ?></span>
        </div>
        <div class="listing-card-actions">
          <form method="post" action="/admin/listings/moderate" class="inline-form">
            <?= Csrf::field() ?>
            <input type="hidden" name="listing_id" value="<?= h($row['id']) ?>">
            <input type="hidden" name="listing_table" value="<?= $section['route'] === 'items' ? 'item' : 'property' ?>">
            <button name="action" value="approve" class="btn-sm btn-success">Approve</button>
          </form>
          <form method="post" action="/admin/listings/moderate" class="inline-form reject-form">
            <?= Csrf::field() ?>
            <input type="hidden" name="listing_id" value="<?= h($row['id']) ?>">
            <input type="hidden" name="listing_table" value="<?= $section['route'] === 'items' ? 'item' : 'property' ?>">
            <input name="reason" placeholder="Rejection reason" class="reject-input" required>
            <button name="action" value="reject" class="btn-sm btn-danger">Reject</button>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>
<?php endforeach; ?>
