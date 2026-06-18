<div class="form-card" style="margin:0 auto;text-align:center">
  <h1><?= $success ? 'Payment Confirmed' : 'Payment Not Completed' ?></h1>
  <?php if ($success): ?>
    <p style="margin:16px 0">Your listing is now featured. Reference: <strong><?= h($reference ?? '') ?></strong></p>
  <?php else: ?>
    <p style="margin:16px 0">The payment was not verified, so the listing was not featured.</p>
  <?php endif; ?>
  <a class="btn btn-primary" href="/profile">Back to my listings</a>
</div>
