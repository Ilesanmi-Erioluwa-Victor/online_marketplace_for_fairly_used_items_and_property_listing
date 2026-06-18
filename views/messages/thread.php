<h1 style="margin-bottom:20px">Conversation</h1>
<div class="thread" data-thread>
<?php foreach ($messages as $message): ?>
  <div class="message <?= $currentUser && (int) $message['sender_id'] === (int) $currentUser['id'] ? 'mine' : '' ?>">
    <strong><?= h($message['full_name']) ?></strong>
    <p><?= nl2br(h($message['body'])) ?></p>
    <small><?= h($message['created_at']) ?></small>
  </div>
<?php endforeach; ?>
</div>
<form method="post" class="form-card" style="max-width:700px;margin-top:16px">
  <?= Csrf::field() ?>
  <div class="form-group" style="margin-bottom:12px">
    <textarea name="body" required placeholder="Write a message..." minlength="1"></textarea>
  </div>
  <button type="submit">Send</button>
</form>
