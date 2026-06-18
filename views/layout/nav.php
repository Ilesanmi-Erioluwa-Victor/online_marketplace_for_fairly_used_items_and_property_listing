<nav class="topbar">
  <a class="brand" href="/">Fairly Marketplace</a>
  <button class="nav-toggle" type="button" aria-label="Menu">☰</button>
  <div class="nav-links">
    <a href="/">Home</a>
    <a href="/items">Browse Items</a>
    <a href="/properties">Browse Properties</a>
    <?php if ($currentUser): ?>
      <a href="/items/create">Post Item</a>
      <a href="/properties/create">Post Property</a>
      <a href="/messages">Messages</a>
      <a href="/profile">My Listings</a>
      <?php if (($currentUser['role'] ?? '') === 'admin'): ?><a href="/admin">Admin</a><?php endif; ?>
      <form method="post" action="/logout" class="inline"><?= Csrf::field() ?><button type="submit">Logout</button></form>
    <?php else: ?>
      <a href="/login">Login</a>
      <a class="button small" href="/register">Register</a>
    <?php endif; ?>
  </div>
</nav>
