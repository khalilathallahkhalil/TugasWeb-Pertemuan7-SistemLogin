<?php
require_once 'functions.php';

// Clear Session array
$_SESSION = array();

// Clear Cookie "Remember Me" jika ada
if (isset($_COOKIE['remember_user'])) {
    setcookie('remember_user', '', time() - 3600, '/');
}

// Clear Session Cookie dari browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 8. Logout functionality dengan session_destroy()[span_42](start_span)[span_42](end_span)
session_destroy();

// Redirect ke login[span_43](start_span)[span_43](end_span)
header('Location: login.php');
exit;