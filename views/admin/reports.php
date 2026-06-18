<h1 style="margin-bottom:24px">Reports</h1>
<div class="table-wrap">
<table>
  <tr><th>Reporter</th><th>Listing</th><th>Reason</th><th>Status</th><th>Action</th></tr>
  <?php foreach ($reports as $report): ?>
  <tr>
    <td><?= h($report['full_name']) ?></td>
    <td><?= h($report['listing_table']) ?> #<?= h($report['listing_id']) ?></td>
    <td><?= h($report['reason'])?><br><small style="color:var(--text-muted)"><?= h($report['note'] ?? '') ?></small></td>
    <td><span class="badge badge-<?= $report['status'] === 'pending' ? 'warning' : ($report['status'] === 'dismissed' ? 'success' : 'danger') ?>"><?= h($report['status']) ?></span></td>
    <td>
      <form method="post" action="/admin/reports/action" class="inline-form" style="display:inline-flex;gap:4px">
        <?= Csrf::field() ?>
        <input type="hidden" name="report_id" value="<?= h($report['id']) ?>">
        <input type="hidden" name="listing_id" value="<?= h($report['listing_id']) ?>">
        <input type="hidden" name="listing_table" value="<?= h($report['listing_table']) ?>">
        <button name="action" value="dismiss" class="btn-sm btn-outline">Dismiss</button>
        <button name="action" value="remove" class="btn-sm btn-danger">Remove listing</button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
</div>
