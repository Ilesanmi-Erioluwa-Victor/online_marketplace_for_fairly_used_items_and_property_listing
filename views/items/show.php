<article class="detail">
  <div class="gallery">
    <?php foreach ($images as $img): ?><img src="<?= h($img['image_url']) ?>" alt=""><?php endforeach; ?>
    <?php if (empty($images)): ?><img src="https://placehold.co/800x600?text=Item" alt=""><?php endif; ?>
  </div>
  <section>
    <h1><?= h($item['title']) ?></h1>
    <p class="price"><?= money($item['price']) ?></p>
    <p><span class="badge"><?= h($item['status']) ?></span> <span class="badge"><?= h($item['category']) ?></span> <span class="badge"><?= h($item['condition']) ?></span></p>
    <p><?= nl2br(h($item['description'])) ?></p>
    <h2>Seller</h2>
    <p><a href="/users/<?= h($item['user_id']) ?>"><?= h($item['full_name']) ?></a> · <?= h($item['phone']) ?></p>
    <?php if ($currentUser && (int) $currentUser['id'] !== (int) $item['user_id']): ?>
    <form method="post" action="/messages/start" class="form compact"><?= Csrf::field() ?><input type="hidden" name="listing_table" value="item"><input type="hidden" name="listing_id" value="<?= h($item['id']) ?>"><textarea name="body" required>Is this still available?</textarea><button>Contact Seller</button></form>
    <form method="post" action="/items/<?= h($item['id']) ?>/report" class="form compact"><?= Csrf::field() ?><input name="reason" placeholder="Reason" required><textarea name="note" placeholder="Optional note"></textarea><button class="secondary">Report listing</button></form>
    <?php endif; ?>
  </section>
</article>
