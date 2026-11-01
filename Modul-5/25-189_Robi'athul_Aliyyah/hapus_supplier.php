<?php
require_once 'koneksi.php';

// Memeriksa apakah ID tersedia
if (isset($_GET['id'])) {

    // Mengambil ID supplier
    $id = $_GET['id'];

    // Menghapus data berdasarkan ID
    $sql = "DELETE FROM supplier WHERE id = :id";

    $stmt = $DBH->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);
}

// Kembali ke halaman supplier
header("Location: supplier.php");
exit;
?>