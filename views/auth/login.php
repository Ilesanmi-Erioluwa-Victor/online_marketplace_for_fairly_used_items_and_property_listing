<div class="form-card" style="margin:0 auto">
  <h1>Welcome back</h1>
  <p class="subtitle">Log in to your Fairly Market account.</p>
  <form method="post" data-validate>
    <?= Csrf::field() ?>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" required>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" required>
    </div>
    <button type="submit" style="width:100%">Log in</button>
    <div class="form-footer"><a href="/forgot-password">Forgot your password?</a></div>
  </form>
  <div class="form-footer">Don't have an account? <a href="/register">Create one</a></div>
</div>
