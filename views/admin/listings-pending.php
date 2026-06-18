<h1 style="margin-bottom:24px">Pending Listings</h1>
<?php foreach (['Items' => $items, 'Properties' => $properties] as $label => $rows): ?>
<section>
  <h2><?= h($label) ?></h2>
  <div class="table-wrap">
  <table>
    <tr><th>Title</th><th>Price</th><th>Action</th></tr>
    <?php foreach ($rows as $row): ?>
    <tr>
      <td><?= h($row['title']) ?></td>
      <td><?= money($row['price']) ?></td>
      <td>
        <form method="post" action="/admin/listings/moderate" class="inline-form" style="display:inline-flex;gap:6px;align-items:center">
          <?= Csrf::field() ?>
          <input type="hidden" name="listing_id" value="<?= h($row['id']) ?>">
          <input type="hidden" name="listing_table" value="<?= h($row['listing_table']) ?>">
          <input type="hidden" name="action" value="approve">
          <button class="btn-sm btn-success">Approve</button>
        </form>
        <form method="post" action="/admin/listings/moderate" class="inline-form" style="display:inline-flex;gap:6px;align-items:center">
          <?= Csrf::field() ?>
          <input type="hidden" name="listing_id" value="<?= h($row['id']) ?>">
          <input type="hidden" name="listing_table" value="<?= h($row['listing_table']) ?>">
          <input name="reason" placeholder="Reason" style="width:auto;min-width:120px;padding:7px 10px;font-size:13px">
          <button name="action" value="reject" class="btn-sm btn-danger">Reject</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
  </div>
</section>
<?php endforeach; ?>
