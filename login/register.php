<?php
require_once 'functions.php';

// Redirect jika sudah login[span_19](start_span)[span_19](end_span)
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 9. Sanitasi input[span_20](start_span)[span_20](end_span)
    $name     = sanitize($_POST['name'] ?? '');
    $email    = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // 1. Validasi input wajib[span_21](start_span)[span_21](end_span)
    if (empty($name) || empty($email) || empty($password)) {
        $error = "Semua kolom wajib diisi!";
    } 
    // 2. Validasi email dengan filter_var()[span_22](start_span)[span_22](end_span)
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } 
    // 5. Cek duplikasi email[span_23](start_span)[span_23](end_span)
    elseif (find_user_by_email($email)) {
        $error = "Email sudah terdaftar! Gunakan email lain.";
    } 
    else {
        // 3, 4. Hash password & simpan ke JSON[span_24](start_span)[span_24](end_span)
        if (register_user($name, $email, $password)) {
            // 10. Pesan sukses yang jelas[span_25](start_span)[span_25](end_span)
            $success = "Registrasi berhasil! Silakan <a href='login.php'>login di sini</a>.";
        } else {
            $error = "Gagal menyimpan data ke sistem.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Registrasi Akun</h2>

        <!-- 10. Pesan Error & Sukses[span_26](start_span)[span_26](end_span) -->
        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="<?= isset($_POST['name']) ? sanitize($_POST['name']) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? sanitize($_POST['email']) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Daftar</button>
        </form>

        <p class="text-center">Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</body>
</html>