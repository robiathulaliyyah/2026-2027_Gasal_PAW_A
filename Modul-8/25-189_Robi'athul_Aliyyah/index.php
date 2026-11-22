<?php
require_once 'auth.php';

$page_title = "Dashboard";

require_once 'components/header.php';
require_once 'components/navbar.php';
?>

<style>
    body {
        background: #fce4ec;
        font-family: Arial, sans-serif;
    }

    .dashboard {
        padding: 45px 25px;
        text-align: center;
        background: #fce4ec;
        min-height: 75vh;
    }

    .dashboard h1 {
        font-size: 32px;
        color: #e75480;
        margin-bottom: 10px;
    }

    .dashboard .welcome {
        font-size: 17px;
        color: #666;
        margin-bottom: 35px;
    }

    .dashboard .nama-user {
        color: #d63384;
        font-weight: bold;
    }

    .pesan {
        color: #d63384;
        margin-bottom: 20px;
    }

    .menu-container {
        display: flex;
        justify-content: center;
        align-items: stretch;
        gap: 22px;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    .menu-card {
        width: 220px;
        padding: 30px 20px;
        border-radius: 12px;
        color: white;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        transition: 0.3s;
        box-sizing: border-box;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 18px rgba(214,51,132,0.25);
    }

    .menu-card h2 {
        font-size: 22px;
        margin: 0 0 12px;
        color: white;
    }

    .menu-card p {
        color: white;
        font-size: 14px;
        margin: 0;
    }

    .supplier {
        background: #e75480;
    }

    .barang {
        background: #d63384;
    }

    .pelanggan {
        background: #ec6b9a;
    }

    .user {
        background: #c2185b;
    }

    .transaksi {
        background: #d63384;
    }

    .laporan {
        background: #e75480;
    }

    .role-info {
        display: inline-block;
        background: #f8bbd0;
        color: #ad1457;
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 14px;
        margin-bottom: 15px;
    }

    @media (max-width: 600px) {
        .dashboard {
            padding: 30px 15px;
        }

        .dashboard h1 {
            font-size: 25px;
        }

        .menu-card {
            width: 100%;
            max-width: 300px;
        }
    }
</style>

<div class="dashboard">

    <h1>Dashboard Aplikasi Penjualan</h1>

    <p class="welcome">
        Selamat datang,
        <span class="nama-user">
            <?= htmlspecialchars($_SESSION['nama']) ?>
        </span>
    </p>

    <div class="role-info">
        Login sebagai:
        <?= $_SESSION['level'] == 1 ? 'Owner' : 'Kasir' ?>
    </div>

    <?php if (isset($_GET['pesan'])): ?>
        <p class="pesan">
            <?= htmlspecialchars($_GET['pesan']) ?>
        </p>
    <?php endif; ?>

    <p class="welcome">
        Silakan pilih menu untuk melanjutkan aktivitas.
    </p>

    <div class="menu-container">

        <?php if ($_SESSION['level'] == 1): ?>

            <a href="supplier.php" class="menu-card supplier">
                <h2>Supplier</h2>
                <p>Kelola Data Supplier</p>
            </a>

            <a href="barang.php" class="menu-card barang">
                <h2>Barang</h2>
                <p>Kelola Data Barang</p>
            </a>

            <a href="pelanggan.php" class="menu-card pelanggan">
                <h2>Pelanggan</h2>
                <p>Kelola Data Pelanggan</p>
            </a>

            <a href="user.php" class="menu-card user">
                <h2>User</h2>
                <p>Kelola Data Pengguna</p>
            </a>

        <?php endif; ?>

        <a href="transaksi.php" class="menu-card transaksi">
            <h2>Transaksi</h2>
            <p>Kelola Transaksi Penjualan</p>
        </a>

        <a href="laporan_penjualan.php" class="menu-card laporan">
            <h2>Laporan</h2>
            <p>Lihat Laporan Penjualan</p>
        </a>

    </div>

</div>

<?php require_once 'components/footer.php'; ?>