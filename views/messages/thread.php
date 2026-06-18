<h1>Conversation</h1>
<div class="thread" data-thread>
<?php foreach ($messages as $message): ?>
  <div class="message <?= $currentUser && (int) $message['sender_id'] === (int) $currentUser['id'] ? 'mine' : '' ?>">
    <strong><?= h($message['full_name']) ?></strong>
    <p><?= nl2br(h($message['body'])) ?></p>
    <small><?= h($message['created_at']) ?></small>
  </div>
<?php endforeach; ?>
</div>
<form method="post" class="form compact">
  <?= Csrf::field() ?>
  <textarea name="body" required placeholder="Write a message"></textarea>
  <button>Send</button>
</form>
<script src="/js/messages.js"></script>
