<?php

$current_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$url = rtrim($current_url, '/');

$routes = require "routes.php";

if (!function_exists('abort')) {
    function abort($code = 404) {
        http_response_code($code);
        require "views/errors/{$code}.php";
        die();
    }
}

if (array_key_exists($url, $routes)) {
   
    require $routes[$url];
} else {
  
    abort(404);
}