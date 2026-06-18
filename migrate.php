<?php
require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config/config.php';

try {
    $db = \App\Core\Database::getConnection();

    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    $db->exec($schema);

    if (($_ENV['RUN_SEED'] ?? '') === 'true') {
        $seed = file_get_contents(__DIR__ . '/database/seed.sql');
        $db->exec($seed);
        fwrite(STDOUT, "Seed applied. Admin: admin@fairlymarket.ng / admin123 | Users: password123\n");
    }
} catch (\Throwable $e) {
    fwrite(STDERR, "Migration: " . $e->getMessage() . "\n");
}
