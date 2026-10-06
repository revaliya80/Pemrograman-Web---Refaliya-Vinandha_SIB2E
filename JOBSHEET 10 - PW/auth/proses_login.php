<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

$max_attempts = 5;

require __DIR__ . '/../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

if ($_SESSION['login_attempts'] >= $max_attempts) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Terlalu banyak percobaan login gagal. Silakan coba lagi nanti.'
    ];

    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

        if ($remember) {
        setcookie(
            'remember_user',
            $user['id'],
            time() + (30 * 24 * 60 * 60),
            '/'
        );
    }
    
    header('Location: ../index.php');
    exit;
}

// Login gagal
$_SESSION['login_attempts']++;

if ($_SESSION['login_attempts'] >= $max_attempts) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Terlalu banyak percobaan login gagal. Silakan coba lagi nanti.'
    ];
} else {
    $sisa = $max_attempts - $_SESSION['login_attempts'];

    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Username atau password salah. Sisa percobaan: ' . $sisa
    ];
}

header('Location: login.php');
exit;

$_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
header('Location: login.php');
exit;
