<?php
// Memulai session jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Memeriksa apakah pengguna sudah login
if (
    !isset($_SESSION['login']) ||
    $_SESSION['login'] !== true
) {
    header("Location: login.php?pesan=" . urlencode("Silakan login terlebih dahulu!"));
    exit;
}

// Khusus Owner (level 1)
function wajibOwner()
{
    if (!isset($_SESSION['level']) || $_SESSION['level'] != 1) {
        header("Location: index.php?pesan=" . urlencode("Anda tidak memiliki hak akses!"));
        exit;
    }
}

// Owner dan Kasir (level 1 dan 2)
function wajibOwnerAtauKasir()
{
    if (
        !isset($_SESSION['level']) ||
        !in_array($_SESSION['level'], [1, 2])
    ) {
        header("Location: index.php?pesan=" . urlencode("Anda tidak memiliki hak akses!"));
        exit;
    }
}
?>