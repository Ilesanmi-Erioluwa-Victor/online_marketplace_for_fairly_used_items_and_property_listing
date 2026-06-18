<article class="detail">
  <div class="gallery">
    <?php foreach ($images as $img): ?><img src="<?= h($img['image_url']) ?>" alt=""><?php endforeach; ?>
    <?php if (empty($images)): ?><img src="https://placehold.co/800x600?text=Property" alt=""><?php endif; ?>
  </div>
  <section>
    <h1><?= h($property['title']) ?></h1>
    <p class="price"><?= money($property['price']) ?><?= $property['rent_period'] ? '/' . h($property['rent_period']) : '' ?></p>
    <p><span class="badge"><?= h($property['status']) ?></span> <span class="badge"><?= h($property['listing_type']) ?></span> <span class="badge"><?= h($property['property_type']) ?></span></p>
    <p><?= nl2br(h($property['description'])) ?></p>
    <p><?= h($property['bedrooms']) ?> bedrooms · <?= h($property['bathrooms']) ?> bathrooms · <?= h($property['size_sqft']) ?> sqft</p>
    <p><?= h($property['address']) ?>, <?= h($property['city']) ?>, <?= h($property['state']) ?></p>
    <p>Amenities: <?= h(implode(', ', json_decode($property['amenities'] ?? '[]', true) ?: [])) ?></p>
    <h2>Landlord/Agent</h2>
    <p><a href="/users/<?= h($property['user_id']) ?>"><?= h($property['full_name']) ?></a> · <?= h($property['phone']) ?></p>
    <?php if ($currentUser && (int) $currentUser['id'] !== (int) $property['user_id']): ?>
    <form method="post" action="/messages/start" class="form compact"><?= Csrf::field() ?><input type="hidden" name="listing_table" value="property"><input type="hidden" name="listing_id" value="<?= h($property['id']) ?>"><textarea name="body" required>I would like to inspect this property.</textarea><button>Contact Landlord</button></form>
    <form method="post" action="/properties/<?= h($property['id']) ?>/report" class="form compact"><?= Csrf::field() ?><input name="reason" placeholder="Reason" required><textarea name="note" placeholder="Optional note"></textarea><button class="secondary">Report listing</button></form>
    <?php endif; ?>
  </section>
</article>
