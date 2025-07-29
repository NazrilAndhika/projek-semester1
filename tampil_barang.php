<?php
// Membaca data barang dari file barang.txt
$barangs = file('barang.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Fungsi untuk mengurutkan data berdasarkan ID Barang (kolom pertama)
usort($barangs, function($a, $b) {
    $idA = explode(',', $a)[0]; // Ambil ID dari data pertama
    $idB = explode(',', $b)[0]; // Ambil ID dari data kedua
    return $idA <=> $idB; // Urutkan ID dalam urutan menaik
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilkan Barang</title>
    <link rel="stylesheet" href="tampil_barang.css">
</head>
<body>
    <div class="container">
        <h1>Daftar Barang</h1>

        <!-- Tabel untuk menampilkan barang -->
        <?php if (count($barangs) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barangs as $barang): ?>
                <?php list($id, $nama, $harga, $stok) = explode(',', $barang); ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $nama; ?></td>
                    <td><?php echo $harga; ?></td>
                    <td><?php echo $stok; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="no-data">Tidak ada data barang tersedia.</p>
        <?php endif; ?>

        <a href="dashboard.php">Kembali ke Menu Utama</a>
    </div>
</body>
</html>
