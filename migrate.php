<?php
require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config/config.php';

try {
    $db = \App\Core\Database::getConnection();

    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    $db->exec($schema);

    if (($_ENV['RUN_SEED'] ?? '') === 'true') {
        $count = (int) $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        if ($count === 0) {
            $seed = file_get_contents(__DIR__ . '/database/seed.sql');
            $db->exec($seed);
            fwrite(STDOUT, "Seed data applied.\n");
        } else {
            fwrite(STDOUT, "Seed skipped: database already has {$count} users.\n");
        }
    }
} catch (\Throwable $e) {
    fwrite(STDERR, "Migration: " . $e->getMessage() . "\n");
}
