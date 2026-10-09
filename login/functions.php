<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('JSON_FILE', 'users.json');

// 9. Sanitasi input dengan htmlspecialchars()[span_7](start_span)[span_7](end_span)
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// 4. Membaca data dari file JSON[span_8](start_span)[span_8](end_span)
function get_users() {
    if (!file_exists(JSON_FILE)) {
        file_put_contents(JSON_FILE, json_encode([]));
        return [];
    }
    $jsonContent = file_get_contents(JSON_FILE);
    return json_decode($jsonContent, true) ?? [];
}

// Menyimpan array user ke file JSON[span_9](start_span)[span_9](end_span)
function save_users($users) {
    return file_put_contents(JSON_FILE, json_encode($users, JSON_PRETTY_PRINT));
}

// 5. Cek duplikasi email[span_10](start_span)[span_10](end_span)
function find_user_by_email($email) {
    $users = get_users();
    foreach ($users as $user) {
        if (strtolower($user['email']) === strtolower($email)) {
            return $user;
        }
    }
    return null;
}

// Cari user berdasarkan ID
function find_user_by_id($id) {
    $users = get_users();
    foreach ($users as $user) {
        if ($user['id'] === $id) {
            return $user;
        }
    }
    return null;
}

// 3, 4. Simpan registrasi baru dengan password_hash()[span_11](start_span)[span_11](end_span)
function register_user($name, $email, $password) {
    $users = get_users();

    $newUser = [
        'id'       => uniqid('usr_'),
        'name'     => $name,
        'email'    => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT) // Password hash[span_12](start_span)[span_12](end_span)
    ];

    $users[] = $newUser;
    return save_users($users);
}

// Update data profil user (Fitur Bonus)[span_13](start_span)[span_13](end_span)
function update_user_profile($id, $newName, $newEmail) {
    $users = get_users();
    foreach ($users as &$user) {
        if ($user['id'] === $id) {
            $user['name'] = $newName;
            $user['email'] = $newEmail;
            break;
        }
    }
    return save_users($users);
}

// 6. Mengecek status login (Session & Cookie Remember Me)[span_14](start_span)[span_14](end_span)
function is_logged_in() {
    // 1. Cek dari Session[span_15](start_span)[span_15](end_span)
    if (isset($_SESSION['user'])) {
        return true;
    }

    // 2. Cek dari Cookie "Remember Me" (Bonus)[span_16](start_span)[span_16](end_span)
    if (isset($_COOKIE['remember_user'])) {
        $userId = $_COOKIE['remember_user'];
        $user = find_user_by_id($userId);
        if ($user) {
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email']
            ];
            return true;
        }
    }

    return false;
}

// 7. Proteksi dashboard & halaman terproteksi[span_17](start_span)[span_17](end_span)
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
?>