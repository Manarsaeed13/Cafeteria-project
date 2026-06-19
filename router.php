<?php

$current_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$base = rtrim($config['base_url'] ?? '', '/');
$url = rtrim($current_url, '/');
if ($base && str_starts_with($url, $base)) {
    $url = substr($url, strlen($base));
}
if ($url === '') $url = '/';


$routes = require __DIR__ . '/routes.php';

if (!function_exists('abort')) {
    function abort($code = 404) {
        http_response_code($code);
        require BASE_PATH . "views/errors/{$code}.php";
        die();
    }
}

if (array_key_exists($url, $routes)) {
    require __DIR__ . '/' . $routes[$url];
} else {
    abort(404);
}