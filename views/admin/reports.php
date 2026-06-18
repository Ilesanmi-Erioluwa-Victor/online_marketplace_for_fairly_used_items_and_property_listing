<h1>Reports</h1>
<table><tr><th>Reporter</th><th>Listing</th><th>Reason</th><th>Status</th><th>Action</th></tr>
<?php foreach ($reports as $report): ?>
<tr><td><?= h($report['full_name']) ?></td><td><?= h($report['listing_table']) ?> #<?= h($report['listing_id']) ?></td><td><?= h($report['reason']) ?><br><small><?= h($report['note']) ?></small></td><td><?= h($report['status']) ?></td><td>
  <form method="post" action="/admin/reports/action" class="inline"><?= Csrf::field() ?><input type="hidden" name="report_id" value="<?= h($report['id']) ?>"><input type="hidden" name="listing_id" value="<?= h($report['listing_id']) ?>"><input type="hidden" name="listing_table" value="<?= h($report['listing_table']) ?>"><button name="action" value="dismiss" class="small">Dismiss</button><button name="action" value="remove" class="secondary small">Remove listing</button></form>
</td></tr>
<?php endforeach; ?>
</table>
