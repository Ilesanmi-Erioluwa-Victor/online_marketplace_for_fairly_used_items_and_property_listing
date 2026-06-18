<h1>Login</h1>
<form method="post" class="form" data-validate>
  <?= Csrf::field() ?>
  <label>Email <input type="email" name="email" required></label>
  <label>Password <input type="password" name="password" required></label>
  <button type="submit">Login</button>
  <a href="/forgot-password">Forgot password?</a>
</form>
