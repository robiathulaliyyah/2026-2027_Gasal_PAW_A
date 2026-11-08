<?php
session_start();
require_once 'koneksi.php';

function e($data) {
    return htmlspecialchars((string)$data, ENT_QUOTES, 'UTF-8');
}

// =================================
// PROSES HAPUS BARANG
// =================================
if (isset($_POST['hapus'])) {

    $id = (int)$_POST['id'];

    // Mengecek apakah barang sudah digunakan
    $cek = $DBH->prepare("
        SELECT COUNT(*)
        FROM transaksi_detail
        WHERE barang_id = ?
    ");

    $cek->execute([$id]);
    $jumlah = (int)$cek->fetchColumn();

    if ($jumlah > 0) {

        $_SESSION['pesan'] =
            "Barang tidak dapat dihapus karena masih digunakan dalam transaksi.";

    } else {

        try {

            $hapus = $DBH->prepare("
                DELETE FROM barang WHERE id = ?
            ");

            $hapus->execute([$id]);

            if ($hapus->rowCount() > 0) {
                $_SESSION['pesan'] = "Data barang berhasil dihapus.";
            } else {
                $_SESSION['pesan'] = "Data barang tidak ditemukan.";
            }

        } catch (PDOException $e) {

            $_SESSION['pesan'] = "Gagal menghapus data barang.";

        }
    }

    header("Location: barang.php");
    exit;
}

// =================================
// MENAMPILKAN PESAN
// =================================
$pesan = $_SESSION['pesan'] ?? '';
unset($_SESSION['pesan']);

// =================================
// MENGAMBIL DATA BARANG
// =================================
$sql = "
    SELECT
        b.id,
        b.kode_barang,
        b.nama_barang,
        b.harga,
        b.stok,
        s.nama AS supplier
    FROM barang b
    LEFT JOIN supplier s ON s.id = b.supplier_id
    ORDER BY b.id ASC
";

$data = $DBH->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data Barang</title>

    <style>

        body {
            font-family: Arial;
            margin: 25px;
            background: #fff0f5;

        }

        h1 {
            color: #d63384;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            border: 1px solid #f3c4d8;
            padding: 10px;
        }

        th {
            background: #e879a9;
        }

        .pesan {
            padding: 10px;
            background: #fce4ec;
            color: #ad1457;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        button {
            padding: 7px 12px;
            background: #e75480;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

    </style>

</head>

<body>

<h1>Data Barang</h1>

<p>
    <a href="transaksi.php">Ke Halaman Transaksi</a>
</p>

<?php if ($pesan): ?>

    <div class="pesan">
        <?= e($pesan) ?>
    </div>

<?php endif; ?>

<table>

    <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Supplier</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; foreach ($data as $r): ?>

    <tr>

        <td><?= $no++ ?></td>

        <td><?= e($r['kode_barang']) ?></td>

        <td><?= e($r['nama_barang']) ?></td>

        <td>
            Rp <?= number_format($r['harga'], 0, ',', '.') ?>
        </td>

        <td><?= e($r['stok']) ?></td>

        <td><?= e($r['supplier'] ?? '-') ?></td>

        <td>

            <form method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

                <input type="hidden" name="id"
                       value="<?= (int)$r['id'] ?>">

                <button type="submit" name="hapus">
                    Hapus
                </button>

            </form>

        </td>

    </tr>

    <?php endforeach; ?>

    <?php if (!$data): ?>

    <tr>
        <td colspan="7" align="center">
            Belum ada data barang.
        </td>
    </tr>

    <?php endif; ?>

</table>

</body>
</html>