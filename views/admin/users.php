<h1>User Management</h1>
<table><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr>
<?php foreach ($users as $user): ?>
<tr><td><?= h($user['full_name']) ?></td><td><?= h($user['email']) ?></td><td><?= h($user['role']) ?></td><td><?= $user['is_suspended'] ? 'Suspended' : 'Active' ?></td><td>
  <?php if ($user['role'] !== 'admin'): ?><form method="post" action="/admin/users/action" class="inline"><?= Csrf::field() ?><input type="hidden" name="user_id" value="<?= h($user['id']) ?>"><button name="action" value="<?= $user['is_suspended'] ? 'unsuspend' : 'suspend' ?>" class="small"><?= $user['is_suspended'] ? 'Unsuspend' : 'Suspend' ?></button><button name="action" value="delete" class="secondary small">Delete</button></form><?php endif; ?>
</td></tr>
<?php endforeach; ?>
</table>
