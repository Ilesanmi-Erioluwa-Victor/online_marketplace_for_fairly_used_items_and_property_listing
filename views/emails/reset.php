<p>Hello <?= h($name ?? '') ?>,</p>
<p>Reset your <strong>Fairly Market</strong> password using the secure link below:</p>
<p style="margin:24px 0"><a href="<?= h($link ?? '') ?>" style="display:inline-block;background:#1E293B;color:white;padding:12px 24px;border-radius:6px;text-decoration:none;font-weight:600">Reset password</a></p>
<p>This link expires in 1 hour. If you didn't request this, ignore this email.</p>
