<h1>Reset Password</h1>
<form method="post" class="form">
  <?= Csrf::field() ?>
  <input type="hidden" name="token" value="<?= h($token ?? '') ?>">
  <label>New password <input type="password" name="password" minlength="8" required></label>
  <button type="submit">Reset password</button>
</form>
