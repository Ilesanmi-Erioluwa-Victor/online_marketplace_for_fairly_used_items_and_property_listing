<div class="form-card" style="margin:0 auto">
  <h1>Create account</h1>
  <p class="subtitle">Join Fairly Market to buy, sell, and rent.</p>
  <form method="post" data-validate>
    <?= Csrf::field() ?>
    <div class="form-group">
      <label>Full name</label>
      <input name="full_name" required>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>
      <div class="form-group">
        <label>Phone</label>
        <input name="phone" required>
      </div>
    </div>
    <div class="form-group">
      <label>I want to...</label>
      <select name="role">
        <option value="general">Browse listings</option>
        <option value="buyer_seller">Buy &amp; sell items</option>
        <option value="landlord_tenant">Find / list properties</option>
      </select>
    </div>
    <div class="form-group">
      <label>Password <span class="hint">min 8 characters</span></label>
      <input type="password" name="password" minlength="8" required>
    </div>
    <button type="submit" style="width:100%">Create account</button>
  </form>
  <div class="form-footer">Already have an account? <a href="/login">Log in</a></div>
</div>
