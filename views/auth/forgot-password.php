<div class="form-card" style="margin:0 auto">
  <h1>Forgot password</h1>
  <p class="subtitle">Enter your email and we'll send a reset link.</p>
  <form method="post">
    <?= Csrf::field() ?>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" required>
    </div>
    <button type="submit" style="width:100%">Send reset link</button>
  </form>
  <div class="form-footer"><a href="/login">Back to login</a></div>
</div>
