<?php
if (!function_exists('dd')) {
    function dd($data) {
        echo '<pre>'; var_dump($data); echo '</pre>'; die();
    }
}

if (!function_exists('urlIs')) {
    function urlIs($url) {
        return $_SERVER['REQUEST_URI'] === $url;
    }
}

if (!function_exists('authorize')) {
    function authorize($condition, $status = 403) {
        if (!$condition) { abort($status); }
    }
}

if (!function_exists('abort')) {
    function abort($code = 404) {
        http_response_code($code);
     require BASE_PATH . "views/errors/{$code}.php";
        die();
    }
}

if (!function_exists('xss')) {
    function xss($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
?>