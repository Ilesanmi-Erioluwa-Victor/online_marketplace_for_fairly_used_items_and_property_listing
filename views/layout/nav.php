<nav class="nav">
  <div class="nav-inner">
    <a class="nav-brand" href="/">Fairly<span>Market</span></a>
    <button class="hamburger" type="button" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
    <div class="mobile-overlay"></div>
    <div class="nav-links">
      <a href="/">Home</a>
      <a href="/items">Items</a>
      <a href="/properties">Properties</a>
      <?php if ($currentUser): ?>
        <a href="/items/create">Post Item</a>
        <a href="/properties/create">Post Property</a>
        <a href="/messages">Messages<?php if (!empty($unreadCount)): ?><span class="nav-badge"><?= $unreadCount ?></span><?php endif; ?></a>
        <a href="/profile">My Listings</a>
        <?php if (($currentUser['role'] ?? '') === 'admin'): ?><a href="/admin">Admin</a><?php endif; ?>
        <form method="post" action="/logout" class="inline-form"><?= Csrf::field() ?><button type="submit" class="nav-logout">Logout</button></form>
      <?php else: ?>
        <a href="/login">Login</a>
        <a href="/register" class="nav-btn">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
