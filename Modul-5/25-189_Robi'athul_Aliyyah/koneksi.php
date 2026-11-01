<?php
// Konfigurasi database
const HOST = 'localhost';
const USER = 'root';
const PASS = '';
const DBNAME = 'db_penjualan';

// Membuat DSN
const DSN = "mysql:host=" . HOST . ";dbname=" . DBNAME . ";charset=utf8mb4";

// Menghubungkan ke database
try {
    $DBH = new PDO(DSN, USER, PASS);

    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $err) {
    die("Koneksi Gagal: " . $err->getMessage());
}
// echo "Koneksi berhasil";
?>