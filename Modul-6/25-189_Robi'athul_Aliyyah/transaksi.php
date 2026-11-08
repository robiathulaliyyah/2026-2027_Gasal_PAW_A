<?php
session_start();
require_once 'koneksi.php';

function e($data) {
    return htmlspecialchars((string)$data, ENT_QUOTES, 'UTF-8');
}

$id_trx = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// =================================
// TAMBAH TRANSAKSI MASTER
// =================================
if (isset($_POST['tambah_transaksi'])) {

    $sql = "INSERT INTO transaksi
            (waktu_transaksi, keterangan, total, pelanggan_id)
            VALUES (?, ?, 0, ?)";

    $stmt = $DBH->prepare($sql);
    $stmt->execute([
        $_POST['waktu_transaksi'],
        $_POST['keterangan'],
        $_POST['pelanggan_id']
    ]);

    $id_baru = $DBH->lastInsertId();

    header("Location: transaksi.php?id=" . $id_baru);
    exit;
}

// =================================
// TAMBAH DETAIL TRANSAKSI
// =================================
if (isset($_POST['tambah_detail'])) {

    $trx = (int)$_POST['transaksi_id'];
    $barang = (int)$_POST['barang_id'];
    $qty = (int)$_POST['qty'];

    try {

        if ($qty < 1) {
            throw new Exception("Jumlah barang minimal 1.");
        }

        $DBH->beginTransaction();

        // Memeriksa barang yang sudah digunakan
        $cek = $DBH->prepare("
            SELECT COUNT(*)
            FROM transaksi_detail
            WHERE transaksi_id = ? AND barang_id = ?
        ");

        $cek->execute([$trx, $barang]);

        if ($cek->fetchColumn() > 0) {
            throw new Exception("Barang sudah ada dalam transaksi.");
        }

        // Mengambil harga dari tabel barang
        $stmt = $DBH->prepare("
            SELECT harga FROM barang WHERE id = ?
        ");

        $stmt->execute([$barang]);
        $harga = $stmt->fetchColumn();

        if ($harga === false) {
            throw new Exception("Barang tidak ditemukan.");
        }

        // Menyimpan detail transaksi
        $stmt = $DBH->prepare("
            INSERT INTO transaksi_detail
            (transaksi_id, barang_id, harga, qty)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$trx, $barang, $harga, $qty]);

        // Menghitung ulang total transaksi
        $stmt = $DBH->prepare("
            UPDATE transaksi
            SET total = (
                SELECT COALESCE(SUM(harga * qty), 0)
                FROM transaksi_detail
                WHERE transaksi_id = ?
            )
            WHERE id = ?
        ");

        $stmt->execute([$trx, $trx]);

        $DBH->commit();

        $_SESSION['pesan'] = "Detail berhasil ditambahkan dan total diperbarui.";

    } catch (Exception $e) {

        if ($DBH->inTransaction()) {
            $DBH->rollBack();
        }

        $_SESSION['pesan'] = $e->getMessage();
    }

    header("Location: transaksi.php?id=" . $trx);
    exit;
}

// =================================
// MENAMPILKAN PESAN
// =================================
$pesan = $_SESSION['pesan'] ?? '';
unset($_SESSION['pesan']);

// =================================
// DATA MASTER TRANSAKSI
// =================================
$master = $DBH->query("
    SELECT t.*, p.nama AS pelanggan
    FROM transaksi t
    LEFT JOIN pelanggan p ON p.id = t.pelanggan_id
    ORDER BY t.id DESC
")->fetchAll(PDO::FETCH_ASSOC);

// Data pelanggan
$pelanggan = $DBH->query("
    SELECT id, nama FROM pelanggan ORDER BY nama
")->fetchAll(PDO::FETCH_ASSOC);

// =================================
// DATA DETAIL TRANSAKSI
// =================================
$trx = null;
$detail = [];
$opsi_barang = [];

if ($id_trx > 0) {

    $stmt = $DBH->prepare("
        SELECT t.*, p.nama AS pelanggan
        FROM transaksi t
        LEFT JOIN pelanggan p ON p.id = t.pelanggan_id
        WHERE t.id = ?
    ");

    $stmt->execute([$id_trx]);
    $trx = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($trx) {

        // Menampilkan detail barang
        $stmt = $DBH->prepare("
            SELECT b.kode_barang, b.nama_barang,
                   d.harga, d.qty,
                   (d.harga * d.qty) AS subtotal
            FROM transaksi_detail d
            JOIN barang b ON b.id = d.barang_id
            WHERE d.transaksi_id = ?
        ");

        $stmt->execute([$id_trx]);
        $detail = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Dropdown hanya menampilkan barang yang belum digunakan
        $stmt = $DBH->prepare("
            SELECT id, kode_barang, nama_barang, harga
            FROM barang
            WHERE id NOT IN (
                SELECT barang_id
                FROM transaksi_detail
                WHERE transaksi_id = ?
            )
            ORDER BY nama_barang
        ");

        $stmt->execute([$id_trx]);
        $opsi_barang = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data Transaksi</title>

    <style>
        body {
            font-family: Arial;
            margin: 25px;
            background: #fce4ec;
        }

        h1, h2, h3 {
            color: #e75480;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #e75480;
            padding: 10px;
        }

        th {
            background: #e75480;
            color: white;
        }

        .box {
            background: white;
            border: 1px solid #e75480;
            padding: 15px;
            margin-bottom: 20px;
        }

        input, select {
            padding: 7px;
            margin: 5px;
            border: 1px solid #e75480;
            border-radius: 4px;
        }

        button {
            padding: 8px 15px;
            background: #d63384;
            color: white;
            border: 4px;
            cursor: pointer;
        }

        .pesan {
            padding: 10px;
            background: #dbeafe;
            margin-bottom: 15px;
            color: #1565c0;
            border-radius: 4px;
        }

        .aktif {
            background: #fce4ec;
        }
    </style>
</head>

<body>

<h1>Data Transaksi</h1>

<p>
    <a href="barang.php">Ke Halaman Barang</a>
</p>

<?php if ($pesan): ?>
    <div class="pesan"><?= e($pesan) ?></div>
<?php endif; ?>

<h2>Data Master Transaksi</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Pelanggan</th>
        <th>Keterangan</th>
        <th>Total</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($master as $m): ?>
    <tr class="<?= $m['id'] == $id_trx ? 'aktif' : '' ?>">
        <td><?= e($m['id']) ?></td>
        <td><?= e($m['waktu_transaksi']) ?></td>
        <td><?= e($m['pelanggan']) ?></td>
        <td><?= e($m['keterangan']) ?></td>
        <td>Rp <?= number_format($m['total'], 0, ',', '.') ?></td>
        <td>
            <a href="transaksi.php?id=<?= (int)$m['id'] ?>">
                Lihat Detail
            </a>
        </td>
    </tr>
    <?php endforeach; ?>

    <?php if (!$master): ?>
    <tr>
        <td colspan="6">Belum ada transaksi.</td>
    </tr>
    <?php endif; ?>

</table>

<div class="box">

    <h3>Tambah Transaksi Baru</h3>

    <form method="POST">

        <p>
            Tanggal:
            <input type="date" name="waktu_transaksi"
                   value="<?= date('Y-m-d') ?>" required>
        </p>

        <p>
            Pelanggan:

            <select name="pelanggan_id" required>
                <option value="">-- Pilih Pelanggan --</option>

                <?php foreach ($pelanggan as $p): ?>
                    <option value="<?= (int)$p['id'] ?>">
                        <?= e($p['nama']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </p>

        <p>
            Keterangan:
            <input type="text" name="keterangan">
        </p>

        <button type="submit" name="tambah_transaksi">
            Simpan Transaksi
        </button>

    </form>

</div>

<?php if ($trx): ?>

<hr>

<h2>Detail Transaksi #<?= e($trx['id']) ?></h2>

<p>
    Tanggal: <?= e($trx['waktu_transaksi']) ?><br>
    Pelanggan: <?= e($trx['pelanggan']) ?><br>
    Total:
    <b>Rp <?= number_format($trx['total'], 0, ',', '.') ?></b>
</p>

<table>

    <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>

    <?php $no = 1; foreach ($detail as $d): ?>

    <tr>
        <td><?= $no++ ?></td>
        <td><?= e($d['kode_barang']) ?></td>
        <td><?= e($d['nama_barang']) ?></td>
        <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
        <td><?= e($d['qty']) ?></td>
        <td>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
    </tr>

    <?php endforeach; ?>

    <?php if (!$detail): ?>
    <tr>
        <td colspan="6">Belum ada detail transaksi.</td>
    </tr>
    <?php endif; ?>

</table>

<div class="box">

    <h3>Tambah Detail Barang</h3>

    <?php if (!$opsi_barang): ?>

        <p>Tidak ada barang yang tersedia untuk dipilih.</p>

    <?php else: ?>

    <form method="POST">

        <input type="hidden" name="transaksi_id"
               value="<?= (int)$trx['id'] ?>">

        <p>
            Barang:

            <select name="barang_id" required>

                <option value="">-- Pilih Barang --</option>

                <?php foreach ($opsi_barang as $b): ?>

                <option value="<?= (int)$b['id'] ?>">
                    <?= e($b['kode_barang']) ?> -
                    <?= e($b['nama_barang']) ?>
                    (Rp <?= number_format($b['harga'], 0, ',', '.') ?>)
                </option>

                <?php endforeach; ?>

            </select>
        </p>

        <p>
            Qty:
            <input type="number" name="qty"
                   min="1" value="1" required>
        </p>

        <button type="submit" name="tambah_detail">
            Simpan Detail
        </button>

    </form>

    <?php endif; ?>

</div>

<?php endif; ?>

</body>
</html>