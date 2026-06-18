<h1>Analytics</h1>
<h2>Items by Category</h2>
<table><tr><th>Category</th><th>Count</th><th></th></tr><?php foreach ($itemCategories as $row): ?><tr><td><?= h($row['label']) ?></td><td><?= h($row['total']) ?></td><td><span class="bar" style="width:<?= min(100, (int) $row['total'] * 12) ?>px"></span></td></tr><?php endforeach; ?></table>
<h2>Properties by Type</h2>
<table><tr><th>Type</th><th>Count</th><th></th></tr><?php foreach ($propertyTypes as $row): ?><tr><td><?= h($row['label']) ?></td><td><?= h($row['total']) ?></td><td><span class="bar" style="width:<?= min(100, (int) $row['total'] * 12) ?>px"></span></td></tr><?php endforeach; ?></table>
