<h1 style="margin-bottom:20px">Messages</h1>
<?php if (empty($conversations)): ?>
<div class="empty"><div class="empty-icon">💬</div><p>No conversations yet.</p></div>
<?php else: ?>
<div class="conversations">
<?php foreach ($conversations as $conversation): ?>
  <a class="conversation" href="/messages/<?= h($conversation['id']) ?>">
    <div class="conversation-info">
      <strong><?= h($conversation['listing_title'] ?? 'Listing') ?></strong>
      <p><?= h($conversation['buyer_name']) ?> ↔ <?= h($conversation['seller_name']) ?></p>
      <p><?= h($conversation['last_message'] ?? 'No messages yet') ?></p>
    </div>
  </a>
<?php endforeach; ?>
</div>
<?php endif; ?>
