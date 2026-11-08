-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Nov 2026 pada 08.58
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penjualan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Buku Tulis', 5000, 100, 26),
(2, 'BRG002', 'Pulpen', 3000, 150, 27),
(3, 'BRG003', 'Pensil', 2000, 120, 28),
(4, 'BRG004', 'Penghapus', 1500, 80, 29),
(5, 'BRG005', 'Penggaris', 4000, 90, 30),
(6, 'BRG006', 'Spidol', 7000, 60, 31),
(7, 'BRG007', 'Buku Gambar', 8000, 50, 32),
(8, 'BRG008', 'Stabilo', 6000, 70, 33),
(9, 'BRG009', 'Map Plastik', 2500, 100, 34),
(10, 'BRG010', 'Kertas HVS', 45000, 40, 35);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
(1, 'Andi Saputra', 'L', '081234567801', 'Surabaya'),
(2, 'Siti Aminah', 'P', '081234567802', 'Sidoarjo'),
(3, 'Budi Santoso', 'L', '081234567803', 'Malang'),
(4, 'Dewi Lestari', 'P', '081234567804', 'Gresik'),
(5, 'Rizky Pratama', 'L', '081234567805', 'Bangkalan'),
(6, 'Nur Aisyah', 'P', '081234567806', 'Madura'),
(7, 'Fajar Hidayat', 'L', '081234567807', 'Mojokerto'),
(8, 'Putri Maharani', 'P', '081234567808', 'Kediri'),
(9, 'Agus Setiawan', 'L', '081234567809', 'Jombang'),
(10, 'Rina Oktavia', 'P', '081234567810', 'Lamongan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `waktu_bayar` datetime NOT NULL,
  `total` int(11) NOT NULL,
  `metode` enum('Tunai','Transfer','EDC') NOT NULL,
  `transaksi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-10-01 09:15:00', 10000, 'Tunai', 1),
(2, '2026-10-02 10:30:00', 9000, 'Transfer', 2),
(3, '2026-10-03 11:00:00', 4000, 'EDC', 3),
(4, '2026-10-04 13:20:00', 6000, 'Tunai', 4),
(5, '2026-10-05 14:10:00', 8000, 'Transfer', 5),
(6, '2026-10-06 09:45:00', 21000, 'EDC', 6),
(7, '2026-10-07 10:15:00', 8000, 'Tunai', 7),
(8, '2026-10-08 12:30:00', 12000, 'Transfer', 8),
(9, '2026-10-09 15:00:00', 10000, 'EDC', 9),
(10, '2026-10-10 16:20:00', 45000, 'Tunai', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(26, 'PT Sumber Makmur', '081234567801', 'Surabaya'),
(27, 'CV Berkah Jaya', '081234567802', 'Malang'),
(28, 'PT Maju Bersama', '081234567803', 'Sidoarjo'),
(29, 'CV Sinar Abadi', '081234567804', 'Gresik'),
(30, 'PT Mitra Sejahtera', '081234567805', 'Mojokerto'),
(31, 'CV Karya Mandiri', '081234567806', 'Kediri'),
(32, 'PT Indo Niaga', '081234567807', 'Jombang'),
(33, 'CV Cipta Usaha', '081234567808', 'Pasuruan'),
(34, 'PT Global Persada', '081234567809', 'Lamongan'),
(35, 'CV Sentosa Jaya', '081234567810', 'Bangkalan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `waktu_transaksi` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `total` int(11) NOT NULL,
  `pelanggan_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-01', 'Pembelian alat tulis', 10000, 1),
(2, '2026-10-02', 'Pembelian buku dan pulpen', 9000, 2),
(3, '2026-10-03', 'Pembelian perlengkapan sekolah', 4000, 3),
(4, '2026-10-04', 'Pembelian alat gambar', 6000, 4),
(5, '2026-10-05', 'Pembelian perlengkapan kantor', 8000, 5),
(6, '2026-10-06', 'Pembelian buku tulis', 21000, 6),
(7, '2026-10-07', 'Pembelian alat tulis', 8000, 7),
(8, '2026-10-08', 'Pembelian kertas dan map', 12000, 8),
(9, '2026-10-09', 'Pembelian perlengkapan sekolah', 10000, 9),
(10, '2026-10-10', 'Pembelian alat tulis', 46500, 10),
(11, '2026-11-07', 'pembelian alat tulis', 12000, 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 5000, 2),
(2, 2, 3000, 3),
(3, 3, 2000, 2),
(4, 4, 1500, 4),
(5, 5, 4000, 2),
(6, 6, 7000, 3),
(7, 7, 8000, 1),
(8, 8, 6000, 2),
(9, 9, 2500, 4),
(10, 4, 1500, 1),
(10, 10, 45000, 1),
(11, 2, 3000, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` tinyint(2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(21, 'admin01', 'admin123', 'Admin Utama', 'Surabaya', '081234567801', 1),
(22, 'kasir01', 'kasir123', 'Andi Saputra', 'Sidoarjo', '081234567802', 2),
(23, 'kasir02', 'kasir123', 'Siti Aminah', 'Malang', '081234567803', 2),
(24, 'kasir03', 'kasir123', 'Budi Santoso', 'Gresik', '081234567804', 2),
(25, 'admin02', 'admin123', 'Dewi Lestari', 'Bangkalan', '081234567805', 1),
(26, 'kasir04', 'kasir123', 'Rizky Pratama', 'Mojokerto', '081234567806', 2),
(27, 'kasir05', 'kasir123', 'Nur Aisyah', 'Kediri', '081234567807', 2),
(28, 'kasir06', 'kasir123', 'Fajar Hidayat', 'Jombang', '081234567808', 2),
(29, 'admin03', 'admin123', 'Putri Maharani', 'Lamongan', '081234567809', 1),
(30, 'kasir07', 'kasir123', 'Agus Setiawan', 'Pasuruan', '081234567810', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transaksi_id`,`barang_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
