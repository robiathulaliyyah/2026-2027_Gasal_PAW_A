<?php
session_start();
require_once 'koneksi.php';

function e($data) {
    return htmlspecialchars((string)$data, ENT_QUOTES, 'UTF-8');
}

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

$rekap = [];
$total_pendapatan = 0;
$total_pelanggan = 0;

if ($mulai != '' && $selesai != '') {

    $format = '/^\d{4}-\d{2}-\d{2}$/';

    if (!preg_match($format, $mulai) ||
        !preg_match($format, $selesai) ||
        !checkdate((int)substr($mulai, 5, 2), (int)substr($mulai, 8, 2), (int)substr($mulai, 0, 4)) ||
        !checkdate((int)substr($selesai, 5, 2), (int)substr($selesai, 8, 2), (int)substr($selesai, 0, 4))) {
        die("Format tanggal tidak valid.");
    }

    if ($mulai > $selesai) {
        die("Tanggal mulai tidak boleh melebihi tanggal selesai.");
    }

    $sql = "SELECT
                DATE(waktu_transaksi) AS tgl,
                SUM(total) AS total_harian
            FROM transaksi
            WHERE DATE(waktu_transaksi) BETWEEN ? AND ?
            GROUP BY DATE(waktu_transaksi)
            ORDER BY tgl ASC";

    $stmt = $DBH->prepare($sql);
    $stmt->execute([$mulai, $selesai]);
    $rekap = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql_summary = "SELECT
                        COALESCE(SUM(total), 0) AS pendapatan,
                        COUNT(DISTINCT pelanggan_id) AS pelanggan
                    FROM transaksi
                    WHERE DATE(waktu_transaksi) BETWEEN ? AND ?";

    $stmt_summary = $DBH->prepare($sql_summary);
    $stmt_summary->execute([$mulai, $selesai]);
    $summary = $stmt_summary->fetch(PDO::FETCH_ASSOC);

    $total_pendapatan = $summary['pendapatan'];
    $total_pelanggan = $summary['pelanggan'];
}

$labels = array_column($rekap, 'tgl');
$data_total = array_map('floatval', array_column($rekap, 'total_harian'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Penjualan</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 25px;
            background: #f5f5f5;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1, h2 {
            color: #333;
        }

        input, button {
            padding: 9px;
            margin: 5px;
        }

        button {
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #eeeeee;
        }

        .summary {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background: #eaf2ff;
            padding: 20px;
            border-radius: 8px;
            flex: 1;
        }

        .chart-container {
            max-width: 800px;
            height: 350px;
            margin: 20px auto;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white;
                margin: 10px;
            }

            .container {
                padding: 0;
            }

            .summary {
                display: flex;
            }

            .card {
                border: 1px solid #ccc;
            }
        }
    </style>
</head>
<body>
<div class="container">

    <h1>Laporan Penjualan</h1>
    <div class="no-print">
        <form method="GET">

            <label>Tanggal Mulai:</label>
            <input type="date" name="mulai"
                value="<?= e($mulai) ?>" required>

            <label>Tanggal Selesai:</label>
            <input type="date" name="selesai"
                value="<?= e($selesai) ?>" required>

            <button type="submit">Tampilkan</button>

            <?php if ($mulai && $selesai): ?>
                <button type="button" onclick="window.print()">
                    Cetak
                </button>

                <a href="export_excel.php?mulai=<?= urlencode($mulai) ?>&selesai=<?= urlencode($selesai) ?>">
                    <button type="button">Excel</button>
                </a>
            <?php endif; ?>

        </form>
    </div>

    <?php if (!$mulai || !$selesai): ?>

        <p>Silakan pilih rentang tanggal untuk menampilkan laporan.</p>

    <?php elseif (empty($rekap)): ?>

        <p>Tidak ada transaksi pada rentang tanggal tersebut.</p>

    <?php else: ?>

        <h2>Grafik Penjualan Harian</h2>

        <div class="chart-container">
            <canvas id="grafikPenjualan"></canvas>
        </div>

        <!-- TABEL REKAPITULASI -->
        <h2>Rekapitulasi Penjualan</h2>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Total Pendapatan</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>

            <tbody>
                <?php $no = 1; ?>

                <?php foreach ($rekap as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>

                        <td>
                            Rp <?= number_format($row['total_harian'], 0, ',', '.') ?>
                        </td>

                        <td><?= e($row['tgl']) ?></td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <h2>Ringkasan Penjualan</h2>

        <div class="summary">

            <div class="card">
                <h3>Jumlah Pelanggan Unik</h3>
                <h2><?= e($total_pelanggan) ?> Orang</h2>
            </div>

            <div class="card">
                <h3>Total Pendapatan</h3>
                <h2>
                    Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
                </h2>
            </div>

        </div>

        <script>
            const ctx = document.getElementById('grafikPenjualan');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($labels) ?>,

                    datasets: [{
                        label: 'Total Pendapatan',
                        data: <?= json_encode($data_total) ?>,
                        borderWidth: 1
                    }]
                },

                options: {
                    responsive: true,

                    maintainAspectRatio: false,

                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

    <?php endif; ?>

</div>

</body>
</html>