<h1><?= $success ? 'Payment Confirmed' : 'Payment Not Completed' ?></h1>
<?php if ($success): ?>
  <p>Your listing is now featured for the configured duration. Reference: <?= h($reference ?? '') ?></p>
<?php else: ?>
  <p>The payment was not verified by Paystack, so the listing was not featured.</p>
<?php endif; ?>
<a class="button" href="/profile">Back to my listings</a>
