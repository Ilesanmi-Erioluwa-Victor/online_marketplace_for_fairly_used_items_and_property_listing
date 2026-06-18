<h1 style="margin-bottom:24px">Analytics</h1>

<section>
  <h2>Items by Category</h2>
  <div class="table-wrap">
  <table>
    <tr><th>Category</th><th>Count</th><th></th></tr>
    <?php foreach ($itemCategories as $row): ?>
    <tr><td><?= h($row['label']) ?></td><td><?= h($row['total']) ?></td><td><span class="bar" style="width:<?= min(200, max(20, (int) $row['total'] * 12)) ?>px"></span></td></tr>
    <?php endforeach; ?>
  </table>
  </div>
</section>

<section>
  <h2>Properties by Type</h2>
  <div class="table-wrap">
  <table>
    <tr><th>Type</th><th>Count</th><th></th></tr>
    <?php foreach ($propertyTypes as $row): ?>
    <tr><td><?= h($row['label']) ?></td><td><?= h($row['total']) ?></td><td><span class="bar" style="width:<?= min(200, max(20, (int) $row['total'] * 12)) ?>px"></span></td></tr>
    <?php endforeach; ?>
  </table>
  </div>
</section>
