<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kalau belum login dan tidak punya cookie Remember Me,
// langsung arahkan ke halaman login tanpa mencoba koneksi database.
if (!isset($_SESSION['user_id']) && !isset($_COOKIE['remember_user'])) {
    header('Location: ../auth/login.php');
    exit;
}

// Koneksi database hanya diperlukan jika ada session
// atau cookie Remember Me yang perlu diperiksa.
require __DIR__ . '/koneksi.php';

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user'])) {

    $userId = (int) $_COOKIE['remember_user'];

    $stmt = $pdo->prepare(
        "SELECT id, nama, role FROM users WHERE id = :id"
    );
    $stmt->execute(['id' => $userId]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];
    } else {
        setcookie('remember_user', '', time() - 3600, '/');
    }
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}