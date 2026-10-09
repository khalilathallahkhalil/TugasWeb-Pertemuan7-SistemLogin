<?php
require_once 'functions.php';

// Proteksi halaman[span_40](start_span)[span_40](end_span)
require_login();

$currentUser = $_SESSION['user'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');

    if (empty($name) || empty($email)) {
        $error = "Semua kolom wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } else {
        // Cek jika email diganti dan email baru sudah dipakai orang lain
        $existingUser = find_user_by_email($email);
        if ($existingUser && $existingUser['id'] !== $currentUser['id']) {
            $error = "Email sudah digunakan oleh akun lain!";
        } else {
            // Update data ke JSON & Session
            update_user_profile($currentUser['id'], $name, $email);
            
            $_SESSION['user']['name']  = $name;
            $_SESSION['user']['email'] = $email;
            $currentUser = $_SESSION['user'];

            $success = "Profil berhasil diperbarui!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Profil</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="<?= sanitize($currentUser['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= sanitize($currentUser['email']) ?>" required>
            </div>
            
            <button type="submit" class="btn">Simpan Perubahan</button>
            <a href="dashboard.php" class="btn btn-secondary" style="margin-top: 0.5rem;">Kembali ke Dashboard</a>
        </form>
    </div>
</body>
</html>