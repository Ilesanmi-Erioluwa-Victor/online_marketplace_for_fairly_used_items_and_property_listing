<?php

set_exception_handler(function (\Throwable $e) {
    error_log('FATAL: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);
    echo 'Internal Server Error';
});

if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $publicPath = __DIR__ . $path;
    if (is_file($publicPath)) {
        return false;
    }
}

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\ItemController;
use App\Controllers\MessageController;
use App\Controllers\PaymentController;
use App\Controllers\ProfileController;
use App\Controllers\PropertyController;
use App\Controllers\SearchController;
use App\Core\Router;

session_start();

$config = require __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$home = new HomeController($config);
$auth = new AuthController($config);
$items = new ItemController($config);
$properties = new PropertyController($config);
$search = new SearchController($config);
$messages = new MessageController($config);
$profile = new ProfileController($config);
$admin = new AdminController($config);
$payments = new PaymentController($config);

$router->add('GET', '/', [$home, 'index']);
$router->add('GET', '/search', [$search, 'index']);

$router->add('GET', '/register', [$auth, 'showRegister']);
$router->add('POST', '/register', [$auth, 'register']);
$router->add('GET', '/login', [$auth, 'showLogin']);
$router->add('POST', '/login', [$auth, 'login']);
$router->add('POST', '/logout', [$auth, 'logout']);
$router->add('GET', '/verify-email', [$auth, 'verifyEmail']);
$router->add('GET', '/forgot-password', [$auth, 'showForgotPassword']);
$router->add('POST', '/forgot-password', [$auth, 'forgotPassword']);
$router->add('GET', '/reset-password', [$auth, 'showResetPassword']);
$router->add('POST', '/reset-password', [$auth, 'resetPassword']);

$router->add('GET', '/items', [$items, 'index']);
$router->add('GET', '/items/create', [$items, 'create']);
$router->add('POST', '/items', [$items, 'store']);
$router->add('GET', '/items/{id}', [$items, 'show']);
$router->add('GET', '/items/{id}/edit', [$items, 'edit']);
$router->add('POST', '/items/{id}/edit', [$items, 'update']);
$router->add('POST', '/items/{id}/delete', [$items, 'delete']);
$router->add('POST', '/items/{id}/report', [$items, 'report']);

$router->add('GET', '/properties', [$properties, 'index']);
$router->add('GET', '/properties/create', [$properties, 'create']);
$router->add('POST', '/properties', [$properties, 'store']);
$router->add('GET', '/properties/{id}', [$properties, 'show']);
$router->add('GET', '/properties/{id}/edit', [$properties, 'edit']);
$router->add('POST', '/properties/{id}/edit', [$properties, 'update']);
$router->add('POST', '/properties/{id}/delete', [$properties, 'delete']);
$router->add('POST', '/properties/{id}/report', [$properties, 'report']);

$router->add('GET', '/messages', [$messages, 'inbox']);
$router->add('GET', '/messages/{id}', [$messages, 'thread']);
$router->add('POST', '/messages/start', [$messages, 'start']);
$router->add('POST', '/messages/{id}', [$messages, 'send']);

$router->add('GET', '/profile', [$profile, 'edit']);
$router->add('POST', '/profile', [$profile, 'update']);
$router->add('GET', '/users/{id}', [$profile, 'show']);

$router->add('POST', '/feature', [$payments, 'initiateFeature']);
$router->add('GET', '/payments/callback', [$payments, 'handleCallback']);

$router->add('GET', '/admin', [$admin, 'dashboard']);
$router->add('GET', '/admin/listings-pending', [$admin, 'pendingListings']);
$router->add('POST', '/admin/listings/moderate', [$admin, 'moderateListing']);
$router->add('GET', '/admin/users', [$admin, 'users']);
$router->add('POST', '/admin/users/action', [$admin, 'userAction']);
$router->add('GET', '/admin/reports', [$admin, 'reports']);
$router->add('POST', '/admin/reports/action', [$admin, 'reportAction']);
$router->add('GET', '/admin/analytics', [$admin, 'analytics']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
