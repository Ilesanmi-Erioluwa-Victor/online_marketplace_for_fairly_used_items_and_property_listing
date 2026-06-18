<?php if (($totalPages ?? 0) > 1): ?>
<div class="pagination">
  <?php if ($page > 1): ?>
    <a class="pagination-link" href="?<?= h(http_build_query(array_merge($filters, ['page' => $page - 1]))) ?>">&larr; Previous</a>
  <?php endif; ?>
  <span class="pagination-info">Page <?= h($page) ?> of <?= h($totalPages) ?></span>
  <?php if ($page < $totalPages): ?>
    <a class="pagination-link" href="?<?= h(http_build_query(array_merge($filters, ['page' => $page + 1]))) ?>">Next &rarr;</a>
  <?php endif; ?>
</div>
<?php endif; ?>
