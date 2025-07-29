<?php
// Menyimpan pesan jika barang berhasil diubah atau tidak ditemukan
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idBarang = $_POST['id_barang']; // ID barang yang ingin diubah
    $namaBaru = $_POST['nama_barang']; // Nama barang baru
    $hargaBaru = $_POST['harga']; // Harga baru
    $stokBaru = $_POST['stok']; // Stok baru

    // Membaca data barang dari file barang.txt
    $barangs = file('barang.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $found = false; // Flag untuk mengecek apakah barang ditemukan

    // Validasi apakah ID Barang sudah ada pada data lain
    foreach ($barangs as $index => $barang) {
        $data = explode(',', $barang); // Memisahkan data berdasarkan koma

        // Jika ID cocok dengan inputan dan bukan baris yang sedang diubah
        if ($data[0] === $idBarang && !$found) {
            $found = true; // Tandai barang ini sebagai yang sedang diubah
        } elseif ($data[0] === $idBarang && $found) {
            $message = "ID Barang '$idBarang' sudah ada. Tidak dapat menggunakan ID yang sama.";
            $found = false;
            break;
        }
    }

    // Jika validasi ID lolos dan ditemukan, lakukan perubahan
    if ($found) {
        foreach ($barangs as $index => $barang) {
            $data = explode(',', $barang); // Memisahkan data berdasarkan koma
            if ($data[0] === $idBarang) { // Jika ID cocok
                $barangs[$index] = "$idBarang,$namaBaru,$hargaBaru,$stokBaru"; // Perbarui data
                break;
            }
        }

        // Tulis ulang file barang.txt dengan data yang diperbarui
        file_put_contents('barang.txt', implode(PHP_EOL, $barangs) . PHP_EOL);
        $message = "Barang dengan ID '$idBarang' berhasil diubah!";
    } elseif (!$message) {
        $message = "Barang dengan ID '$idBarang' tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Barang</title>
    <link rel="stylesheet" href="ubah_barang.css">
</head>
<body>
    <div class="container">
        <h1>Ubah Barang</h1>

        <!-- Tampilkan pesan jika barang berhasil diubah atau tidak ditemukan -->
        <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'berhasil') !== false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <!-- Form untuk mengubah barang -->
        <form method="post">
            <label for="id_barang">ID Barang (yang ingin diubah):</label>
            <input type="text" name="id_barang" id="id_barang" required><br>

            <label for="nama_barang">Nama Barang Baru:</label>
            <input type="text" name="nama_barang" id="nama_barang" required><br>

            <label for="harga">Harga Baru:</label>
            <input type="number" name="harga" id="harga" required><br>

            <label for="stok">Stok Baru:</label>
            <input type="number" name="stok" id="stok" required><br>

            <button type="submit">Ubah Barang</button>
        </form>
        <a href="dashboard.php">Kembali ke Menu Utama</a>
    </div>
</body>
</html>
