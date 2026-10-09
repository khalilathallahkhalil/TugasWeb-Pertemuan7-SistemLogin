<?php
require_once 'functions.php';

if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 9. Sanitasi input[span_28](start_span)[span_28](end_span)
    $email    = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (empty($email) || empty($password)) {
        $error = "Email dan password wajib diisi!";
    } else {
        $user = find_user_by_email($email);

        // Verifikasi hashed password[span_29](start_span)[span_29](end_span)
        if ($user && password_verify($password, $user['password'])) {
            // 6. Simpan sesi login[span_30](start_span)[span_30](end_span)
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email']
            ];

            // Fitur Bonus: "Remember Me" menggunakan cookies[span_31](start_span)[span_31](end_span)
            if ($remember) {
                // Simpan cookie selama 7 hari
                setcookie('remember_user', $user['id'], time() + (7 * 24 * 60 * 60), "/");
            }

            header('Location: dashboard.php');
            exit;
        } else {
            // 10. Pesan error[span_32](start_span)[span_32](end_span)
            $error = "Email atau password salah!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login Sistem</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? sanitize($_POST['email']) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <!-- Bonus: Fitur Remember Me[span_33](start_span)[span_33](end_span) -->
            <div class="form-group-checkbox">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" style="margin-bottom: 0;">Remember Me</label>
            </div>

            <button type="submit" class="btn">Masuk</button>
        </form>

        <p class="text-center">Belum punya akun? <a href="register.php">Registrasi</a></p>
    </div>
</body>
</html>