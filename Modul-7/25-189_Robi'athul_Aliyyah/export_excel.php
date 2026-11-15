<?php
require_once 'koneksi.php';

// Mengambil tanggal dari URL
$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

// Validasi tanggal
if (
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $mulai) ||
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $selesai) ||
    $mulai > $selesai
) {
    die("Rentang tanggal tidak valid.");
}

// Mengambil rekap penjualan per hari
$sql = "SELECT
            DATE(waktu_transaksi) AS tgl,
            SUM(total) AS total_harian
        FROM transaksi
        WHERE DATE(waktu_transaksi) BETWEEN ? AND ?
        GROUP BY DATE(waktu_transaksi)
        ORDER BY tgl ASC";

$stmt = $DBH->prepare($sql);
$stmt->execute([$mulai, $selesai]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mengatur nama dan format file Excel
$nama_file = "laporan_penjualan_" . $mulai . "_sampai_" . $selesai . ".xls";

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$nama_file\"");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table border="1">
    <tr>
        <th colspan="3">LAPORAN PENJUALAN</th>
    </tr>
    <tr>
        <th colspan="3">
            Periode <?= htmlspecialchars($mulai) ?>
            sampai <?= htmlspecialchars($selesai) ?>
        </th>
    </tr>
    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>

    <?php
    $no = 1;
    $total_pendapatan = 0;

    foreach ($data as $row):
        $total_pendapatan += $row['total_harian'];
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['total_harian'] ?></td>
        <td><?= $row['tgl'] ?></td>
    </tr>
    <?php endforeach; ?>

    <tr>
        <th colspan="1">Total Keseluruhan</th>
        <th><?= $total_pendapatan ?></th>
        <th></th>
    </tr>
</table>