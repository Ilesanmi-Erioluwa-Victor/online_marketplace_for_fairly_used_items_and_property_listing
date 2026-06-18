<h1 style="margin-bottom:24px">User Management</h1>
<div class="table-wrap">
<table>
  <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr>
  <?php foreach ($users as $user): ?>
  <tr>
    <td><?= h($user['full_name']) ?></td>
    <td><?= h($user['email']) ?></td>
    <td><?= h($user['role']) ?></td>
    <td><?php if ($user['is_suspended']): ?><span class="badge badge-danger">Suspended</span><?php else: ?><span class="badge badge-success">Active</span><?php endif; ?></td>
    <td>
      <?php if ($user['role'] !== 'admin'): ?>
      <form method="post" action="/admin/users/action" class="inline-form" style="display:inline-flex;gap:4px">
        <?= Csrf::field() ?>
        <input type="hidden" name="user_id" value="<?= h($user['id']) ?>">
        <button name="action" value="<?= $user['is_suspended'] ? 'unsuspend' : 'suspend' ?>" class="btn-sm <?= $user['is_suspended'] ? 'btn-success' : 'btn-outline' ?>"><?= $user['is_suspended'] ? 'Unsuspend' : 'Suspend' ?></button>
        <button name="action" value="delete" class="btn-sm btn-danger">Delete</button>
      </form>
      <?php endif; ?>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
</div>
