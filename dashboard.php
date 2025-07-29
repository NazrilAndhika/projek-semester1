<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> <!-- Link Font Awesome -->
</head>
<body>
    <div class="container">
        <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['username']); ?></h2>
        <p>di Web Pengelolaan Barang UMKM</p>
        <p>Silakan Pilih Sesuai Kebutuhan yang Diperlukan</p>

        <!-- Menu Dashboard -->
        <div class="menu">
            <a href="tambah_barang.php">
                <i class="fas fa-plus-circle"></i> Tambah Data Barang
            </a>
            <a href="ubah_barang.php">
                <i class="fas fa-edit"></i> Ubah Data Barang
            </a>
            <a href="hapus_barang.php">
                <i class="fas fa-trash-alt"></i> Hapus Data Barang
            </a>
            <a href="cari_barang.php">
                <i class="fas fa-search"></i> Cari Data Barang
            </a>
            <a href="tampil_barang.php">
                <i class="fas fa-table"></i> Tampilkan Data Barang
            </a>
        </div>

        <!-- Logout Link -->
        <div class="logout-link">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</body>
</html>
