<?php
require_once 'koneksi.php';

$page_title = "Tambah Data Supplier";

// Proses menyimpan data
if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO supplier (nama, telp, alamat)
            VALUES (:nama, :telp, :alamat)";

    $stmt = $DBH->prepare($sql);

    $stmt->execute([
        ':nama' => $nama,
        ':telp' => $telp,
        ':alamat' => $alamat
    ]);

    header("Location: supplier.php");
    exit;
}

include 'components/header.php';
include 'components/navbar.php';
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background: white;
    }

    .content {
        max-width: 700px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .judul {
        color: #548b9b;
        font-size: 24px;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 7px;
        font-size: 14px;
        font-weight: bold;
    }

    input, textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        box-sizing: border-box;
        font-size: 14px;
    }

    textarea {
        height: 100px;
        resize: vertical;
    }

    .simpan {
        background: #28a745;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 3px;
        cursor: pointer;
    }

    .kembali {
        background: #dc3545;
        color: white;
        padding: 10px 18px;
        text-decoration: none;
        border-radius: 3px;
        font-size: 13px;
    }
</style>

<main class="content">

    <h1 class="judul">Tambah Data Master Supplier</h1>

    <form method="POST">

        <div class="form-group">
            <label>Nama Supplier</label>
            <input type="text" name="nama" required>
        </div>

        <div class="form-group">
            <label>Telp</label>
            <input type="text" name="telp">
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat"></textarea>
        </div>

        <button type="submit" name="simpan" class="simpan">
            Simpan
        </button>

        <a href="supplier.php" class="kembali">
            Batal
        </a>

    </form>

</main>

<?php include 'components/footer.php'; ?>