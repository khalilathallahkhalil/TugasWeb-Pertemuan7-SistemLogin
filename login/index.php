<?php
require_once 'functions.php';

// Jika pengguna sudah login, langsung alihkan ke Dashboard
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

// Jika belum login, alihkan ke halaman Login
header('Location: login.php');
exit;
?>