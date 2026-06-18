<h1>Admin Dashboard</h1>
<div class="stats">
  <div><strong><?= h($stats['users']) ?></strong><span>Users</span></div>
  <div><strong><?= h($stats['items']) ?></strong><span>Items</span></div>
  <div><strong><?= h($stats['properties']) ?></strong><span>Properties</span></div>
  <div><strong><?= h($stats['pending']) ?></strong><span>Pending</span></div>
  <div><strong><?= money($stats['revenue']) ?></strong><span>Featured Revenue</span></div>
</div>
<div class="admin-links"><a class="button" href="/admin/listings-pending">Moderate Listings</a><a class="button" href="/admin/users">Users</a><a class="button" href="/admin/reports">Reports</a><a class="button" href="/admin/analytics">Analytics</a></div>
<h2>Recent Signups</h2>
<table><tr><th>Name</th><th>Email</th><th>Role</th></tr><?php foreach ($recent as $user): ?><tr><td><?= h($user['full_name']) ?></td><td><?= h($user['email']) ?></td><td><?= h($user['role']) ?></td></tr><?php endforeach; ?></table>
<h2>Featured Listings</h2>
<table><tr><th>Type</th><th>Listing</th><th>Amount</th><th>Until</th></tr><?php foreach ($featured as $f): ?><tr><td><?= h($f['listing_table']) ?></td><td><?= h($f['listing_id']) ?></td><td><?= money($f['amount']) ?></td><td><?= h($f['featured_until']) ?></td></tr><?php endforeach; ?></table>
