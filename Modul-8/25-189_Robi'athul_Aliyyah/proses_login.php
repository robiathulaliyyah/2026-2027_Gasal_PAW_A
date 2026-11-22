<?php
session_start();
require_once 'koneksi.php';

// Mengambil data dari form
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Mencari user berdasarkan username
$stmt = $DBH->prepare(
    "SELECT * FROM user WHERE username = :username"
);

$stmt->execute([
    ':username' => $username
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Memeriksa username dan password
if ($user && $password === $user['password']) {

    // Menyimpan data ke session
    session_regenerate_id(true);

    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['level'] = $user['level'];

    header("Location: index.php");
    exit;

} else {

    header("Location: login.php?pesan=" .
        urlencode("Username atau password salah!"));
    exit;
}
?>