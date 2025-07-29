<?php
// Cek jika form disubmit untuk mencari barang
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namaCari = $_POST['nama_cari']; // Nama barang yang ingin dicari

    // Membaca data barang dari file barang.txt
    $barangs = file('barang.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $hasil = []; // Menyimpan hasil pencarian

    // Loop untuk mencari barang yang nama barangnya sesuai
    foreach ($barangs as $barang) {
        list($id, $nama, $harga, $stok) = explode(',', $barang);
        if (stripos($nama, $namaCari) !== false) { // Pencarian case-insensitive
            $hasil[] = $barang; // Menyimpan barang yang ditemukan
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Barang</title>
    <link rel="stylesheet" href="cari_barang.css">
</head>
<body>
    <div class="container">
        <h1>Cari Barang</h1>
        
        <!-- Form untuk mencari barang -->
        <form method="post">
            <label for="nama_cari">Nama Barang:</label>
            <input type="text" name="nama_cari" id="nama_cari" required><br>

            <button type="submit">Cari Barang</button>
        </form>

        <!-- Tampilkan hasil pencarian -->
        <?php if (isset($hasil)): ?>
        <h2>Hasil Pencarian</h2>
        <?php if (count($hasil) > 0): ?>
        <table>
            <tr>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
            <?php
            foreach ($hasil as $barang) {
                list($id, $nama, $harga, $stok) = explode(',', $barang);
                echo "<tr>
                        <td>$id</td>
                        <td>$nama</td>
                        <td>$harga</td>
                        <td>$stok</td>
                      </tr>";
            }
            ?>
        </table>
        <?php else: ?>
        <p>Barang dengan nama "<?php echo htmlspecialchars($namaCari); ?>" tidak ditemukan.</p>
        <?php endif; ?>
        <?php endif; ?>

        <a href="dashboard.php">Kembali ke Menu Utama</a>
    </div>
</body>
</html>