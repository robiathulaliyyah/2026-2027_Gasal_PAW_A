<?php
require_once 'auth.php';

// Memeriksa level pengguna
if ($_SESSION['level'] != 1) {
    header("Location: index.php?pesan=" . urlencode("Anda tidak memiliki hak akses!"));
    exit;
}
?>