<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off','samesite'=>'Lax']);
    session_start();
}
function require_login(): void {
    if (empty($_SESSION['user'])) { header('Location: login.php'); exit; }
}
function current_user(): array { return $_SESSION['user'] ?? []; }
