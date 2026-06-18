<?php
require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config/config.php';

$sql = file_get_contents(__DIR__ . '/database/schema.sql');

try {
    $db = \App\Core\Database::getConnection();
    $db->exec($sql);
} catch (\Throwable $e) {
    fwrite(STDERR, "Migration skipped: " . $e->getMessage() . "\n");
}
