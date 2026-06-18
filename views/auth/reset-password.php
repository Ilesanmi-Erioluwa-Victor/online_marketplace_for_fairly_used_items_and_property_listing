<div class="form-card" style="margin:0 auto">
  <h1>Reset password</h1>
  <p class="subtitle">Choose a new password for your account.</p>
  <form method="post">
    <?= Csrf::field() ?>
    <input type="hidden" name="token" value="<?= h($token ?? '') ?>">
    <div class="form-group">
      <label>New password <span class="hint">min 8 characters</span></label>
      <input type="password" name="password" minlength="8" required>
    </div>
    <button type="submit" style="width:100%">Reset password</button>
  </form>
</div>
