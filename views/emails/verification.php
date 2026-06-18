<p>Hello <?= h($name ?? '') ?>,</p>
<p>Thanks for joining <strong>Fairly Market</strong>. Please verify your email address by clicking the link below:</p>
<p style="margin:24px 0"><a href="<?= h($link ?? '') ?>" style="display:inline-block;background:#1E293B;color:white;padding:12px 24px;border-radius:6px;text-decoration:none;font-weight:600">Verify email</a></p>
<p>If you didn't create this account, you can ignore this email.</p>
