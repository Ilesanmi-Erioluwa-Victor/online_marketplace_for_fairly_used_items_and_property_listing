<h1>Forgot Password</h1>
<form method="post" class="form">
  <?= Csrf::field() ?>
  <label>Email <input type="email" name="email" required></label>
  <button type="submit">Send reset link</button>
</form>
