<?php
require_once 'functions.php';

// 7. Dashboard diproteksi (redirect jika belum login)[span_35](start_span)[span_35](end_span)
require_login();

$currentUser = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard Utama</h2>
        
        <!-- 9. Sanitasi output[span_36](start_span)[span_36](end_span) -->
        <p style="text-align: center; margin-bottom: 0.5rem; font-size: 1.1rem;">
            Selamat Datang, <strong><?= sanitize($currentUser['name']) ?></strong>!
        </p>
        <p style="text-align: center; color: #94a3b8; font-size: 0.9rem; margin-bottom: 1.5rem;">
            Email: <?= sanitize($currentUser['email']) ?>
        </p>

        <div class="action-buttons">
            <!-- Bonus: Navigasi Edit Profile[span_37](start_span)[span_37](end_span) -->
            <a href="edit_profile.php" class="btn btn-secondary">Edit Profil</a>
            
            <!-- 8. Logout functionality[span_38](start_span)[span_38](end_span) -->
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>
</html>