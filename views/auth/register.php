<h1>Create Account</h1>
<form method="post" class="form" data-validate>
  <?= Csrf::field() ?>
  <label>Full name <input name="full_name" required></label>
  <label>Email <input type="email" name="email" required></label>
  <label>Phone <input name="phone" required></label>
  <label>Role <select name="role"><option value="general">General User</option><option value="buyer_seller">Buyer/Seller</option><option value="landlord_tenant">Landlord/Tenant</option></select></label>
  <label>Password <input type="password" name="password" minlength="8" required></label>
  <button type="submit">Register</button>
</form>
