<?php
require_once 'koneksi.php';

$page_title = "Edit Data Master Supplier";

// Mengambil ID supplier dari URL
if (!isset($_GET['id'])) {
    header("Location: supplier.php");
    exit;
}

$id = $_GET['id'];

// Mengambil data supplier berdasarkan ID
$sql = "SELECT * FROM supplier WHERE id = :id";
$stmt = $DBH->prepare($sql);
$stmt->execute([':id' => $id]);

$supplier = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika data tidak ditemukan
if (!$supplier) {
    die("Data supplier tidak ditemukan!");
}

// Proses memperbarui data
if (isset($_POST['update'])) {

    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE supplier
            SET nama = :nama,
                telp = :telp,
                alamat = :alamat
            WHERE id = :id";

    $stmt = $DBH->prepare($sql);

    $stmt->execute([
        ':nama' => $nama,
        ':telp' => $telp,
        ':alamat' => $alamat,
        ':id' => $id
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

    .update {
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

    <h1 class="judul">Edit Data Master Supplier</h1>

    <form method="POST">

        <div class="form-group">
            <label>Nama Supplier</label>
            <input
                type="text"
                name="nama"
                value="<?= htmlspecialchars($supplier['nama']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label>Telp</label>
            <input
                type="text"
                name="telp"
                value="<?= htmlspecialchars($supplier['telp'] ?? '') ?>"
            >
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat"><?= htmlspecialchars($supplier['alamat'] ?? '') ?></textarea>
        </div>

        <button type="submit" name="update" class="update">
            Update
        </button>

        <a href="supplier.php" class="kembali">
            Batal
        </a>

    </form>

</main>

<?php include 'components/footer.php'; ?>