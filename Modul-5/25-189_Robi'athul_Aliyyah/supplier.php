<?php
require_once 'koneksi.php';

$page_title = "Data Master Supplier";

// Mengambil seluruh data supplier dari database
$sql = "SELECT * FROM supplier ORDER BY id ASC";
$result = $DBH->query($sql);

$data_supplier = $result->fetchAll(PDO::FETCH_ASSOC);

include 'components/header.php';
include 'components/navbar.php';
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background: white;
    }

    .content {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .judul {
        color: #548b9b;
        font-size: 24px;
        margin-bottom: 25px;
    }

    .header-tabel {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 15px;
    }

    .tambah {
        background: #78a943;
        color: white;
        padding: 9px 15px;
        text-decoration: none;
        font-size: 12px;
        border-radius: 3px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    th {
        background: #d9edf7;
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    td {
        padding: 10px;
        border: 1px solid #ddd;
    }

    tr:hover {
        background: #f5f5f5;
    }

    .edit {
        background: #e87922;
        color: white;
        padding: 7px 10px;
        text-decoration: none;
        border-radius: 3px;
    }

    .hapus {
        background: #c62828;
        color: white;
        padding: 7px 10px;
        text-decoration: none;
        border-radius: 3px;
    }

    @media(max-width: 600px) {
        .content {
            padding: 0 10px;
        }

        table {
            font-size: 11px;
        }
    }
</style>

<main class="content">

    <h1 class="judul">Data Master Supplier Baru</h1>

    <div class="header-tabel">
        <a href="tambah_supplier.php" class="tambah">
            Tambah Data
        </a>
    </div>

    <div style="overflow-x:auto;">

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Telp</th>
                    <th>Alamat</th>
                    <th>Tindakan</th>
                </tr>
            </thead>

            <tbody>

                <?php if (count($data_supplier) > 0): ?>

                    <?php $no = 1; ?>

                    <?php foreach ($data_supplier as $row): ?>

                        <tr>
                            <td><?= $no++ ?></td>

                            <td>
                                <?= htmlspecialchars($row['nama']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['telp'] ?? '') ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['alamat'] ?? '') ?>
                            </td>

                            <td>
                                <a href="edit_supplier.php?id=<?= $row['id'] ?>"
                                   class="edit">Edit</a>

                                <a href="hapus_supplier.php?id=<?= $row['id'] ?>"
                                   class="hapus"
                                   onclick="return confirm('Anda yakin akan menghapus supplier ini?')">
                                    Hapus
                                </a>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="5" style="text-align:center;">
                            Belum ada data supplier.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>

    </div>

</main>

<?php include 'components/footer.php'; ?>