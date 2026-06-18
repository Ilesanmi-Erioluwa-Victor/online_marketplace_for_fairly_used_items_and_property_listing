<h1 style="margin-bottom:24px">Admin Dashboard</h1>
<div class="stats">
  <div class="stat-card"><strong><?= h($stats['users']) ?></strong><span>Users</span></div>
  <div class="stat-card"><strong><?= h($stats['items']) ?></strong><span>Items</span></div>
  <div class="stat-card"><strong><?= h($stats['properties']) ?></strong><span>Properties</span></div>
  <div class="stat-card"><strong><?= h($stats['pending']) ?></strong><span>Pending</span></div>
  <div class="stat-card"><strong><?= money($stats['revenue']) ?></strong><span>Featured Revenue</span></div>
</div>
<div class="admin-nav">
  <a href="/admin/listings-pending">Moderate Listings</a>
  <a href="/admin/users">Users</a>
  <a href="/admin/reports">Reports</a>
  <a href="/admin/analytics">Analytics</a>
</div>

<section>
  <h2>Recent Signups</h2>
  <div class="table-wrap">
  <table>
    <tr><th>Name</th><th>Email</th><th>Role</th></tr>
    <?php foreach ($recent as $user): ?>
    <tr><td><?= h($user['full_name']) ?></td><td><?= h($user['email']) ?></td><td><?= h($user['role']) ?></td></tr>
    <?php endforeach; ?>
  </table>
  </div>
</section>

<section>
  <h2>Featured Listings</h2>
  <div class="table-wrap">
  <table>
    <tr><th>Type</th><th>Listing</th><th>Amount</th><th>Until</th></tr>
    <?php foreach ($featured as $f): ?>
    <tr><td><?= h($f['listing_table']) ?></td><td><?= h($f['listing_id']) ?></td><td><?= money($f['amount']) ?></td><td><?= h($f['featured_until']) ?></td></tr>
    <?php endforeach; ?>
  </table>
  </div>
</section>
