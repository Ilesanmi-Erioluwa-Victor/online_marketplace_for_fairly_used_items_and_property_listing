<?php

use Dotenv\Dotenv;

$root = dirname(__DIR__);

if (file_exists($root . '/vendor/autoload.php')) {
    require_once $root . '/vendor/autoload.php';
}

if (class_exists(Dotenv::class) && file_exists($root . '/.env')) {
    Dotenv::createImmutable($root)->safeLoad();
}

$env = $_ENV['APP_ENV'] ?? 'local';
ini_set('display_errors', $env === 'production' ? '0' : '1');
error_reporting(E_ALL);

return [
    'app_name' => 'Fairly Marketplace',
    'app_url' => rtrim($_ENV['APP_URL'] ?? 'http://localhost:8000', '/'),
    'item_feature_fee' => 1500,
    'property_feature_fee' => 3000,
    'feature_days' => 7,
    'max_images' => 6,
    'max_upload_bytes' => 5 * 1024 * 1024,
    'allowed_mimes' => ['image/jpeg', 'image/png', 'image/webp'],
];
