<h1>Messages</h1>
<?php if (empty($conversations)): ?><p class="empty">No conversations yet.</p><?php endif; ?>
<div class="list">
<?php foreach ($conversations as $conversation): ?>
  <a class="row" href="/messages/<?= h($conversation['id']) ?>">
    <strong><?= h($conversation['listing_title'] ?? 'Listing') ?></strong>
    <span><?= h($conversation['buyer_name']) ?> ↔ <?= h($conversation['seller_name']) ?></span>
    <small><?= h($conversation['last_message'] ?? 'No messages yet') ?></small>
  </a>
<?php endforeach; ?>
</div>
<script src="/js/messages.js"></script>
