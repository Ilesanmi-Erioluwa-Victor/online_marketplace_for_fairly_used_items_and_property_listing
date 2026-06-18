<p>Hello <?= h($name ?? '') ?>,</p>
<p>Reset your password using this secure link:</p>
<p><a href="<?= h($link ?? '') ?>">Reset password</a></p>
