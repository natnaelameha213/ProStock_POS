<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function require_login() {
    if (empty($_SESSION['user'])) {
        header("Location: " . base_url("auth/login.php"));
        exit;
    }
}
function require_role($roles) {
    require_login();
    if (!in_array($_SESSION['user']['role'], (array)$roles, true)) {
        http_response_code(403);
        exit("Access denied.");
    }
}
function base_url($path = '') {
    $base = '/ProStock_POS/';
    return $base . ltrim($path, '/');
}
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function money($v) { return number_format((float)$v, 2); }
function flash($type, $msg) { $_SESSION['flash'] = [$type, $msg]; }
function show_flash() {
    if (!empty($_SESSION['flash'])) {
        [$type,$msg] = $_SESSION['flash'];
        unset($_SESSION['flash']);
        echo '<div class="alert alert-'.e($type).' alert-dismissible fade show">'.e($msg).'<button class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}
