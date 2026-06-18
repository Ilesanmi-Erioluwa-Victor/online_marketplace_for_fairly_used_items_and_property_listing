<h1>Pending Listings</h1>
<?php foreach (['Items' => $items, 'Properties' => $properties] as $label => $rows): ?>
<h2><?= h($label) ?></h2>
<table><tr><th>Title</th><th>Price</th><th>Action</th></tr>
<?php foreach ($rows as $row): ?>
<tr><td><?= h($row['title']) ?></td><td><?= money($row['price']) ?></td><td>
  <form method="post" action="/admin/listings/moderate" class="inline"><?= Csrf::field() ?><input type="hidden" name="listing_id" value="<?= h($row['id']) ?>"><input type="hidden" name="listing_table" value="<?= h($row['listing_table']) ?>"><input type="hidden" name="action" value="approve"><button class="small">Approve</button></form>
  <form method="post" action="/admin/listings/moderate" class="inline"><?= Csrf::field() ?><input type="hidden" name="listing_id" value="<?= h($row['id']) ?>"><input type="hidden" name="listing_table" value="<?= h($row['listing_table']) ?>"><input name="reason" placeholder="Reason"><button name="action" value="reject" class="secondary small">Reject</button></form>
</td></tr>
<?php endforeach; ?>
</table>
<?php endforeach; ?>
