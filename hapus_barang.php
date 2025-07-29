<?php
// Menyimpan pesan jika barang berhasil dihapus atau tidak ditemukan
$message = '';

// Cek jika form disubmit untuk menghapus barang
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idHapus = $_POST['id_hapus']; // ID barang yang ingin dihapus

    // Membaca data barang dari file barang.txt
    $barangs = file('barang.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $found = false; // Flag untuk mengecek apakah barang ditemukan

    // Loop untuk mencari barang dengan ID yang sesuai
    foreach ($barangs as $index => $barang) {
        list($id, $nama, $harga, $stok) = explode(',', $barang);
        if ($id === $idHapus) {
            // Jika ID ditemukan, hapus data barang dari array
            unset($barangs[$index]);
            $found = true;
            break;
        }
    }

    // Jika barang ditemukan, tulis ulang file tanpa data yang dihapus
    if ($found) {
        file_put_contents('barang.txt', implode(PHP_EOL, $barangs) . PHP_EOL);
        $message = "Barang dengan ID '$idHapus' berhasil dihapus!";
    } else {
        // Jika barang tidak ditemukan
        $message = "Barang dengan ID '$idHapus' tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Barang</title>
    <link rel="stylesheet" href="hapus_barang.css">
</head>
<body>
    <div class="container">
        <h1>Hapus Barang</h1>
        
        <!-- Form untuk menghapus barang -->
        <form method="post">
            <label for="id_hapus">ID Barang:</label>
            <input type="text" name="id_hapus" id="id_hapus" required><br>

            <button type="submit">Hapus Barang</button>
        </form>

        <!-- Tampilkan pesan hasil penghapusan -->
        <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'berhasil') !== false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <a href="dashboard.php">Kembali ke Menu Utama</a>
    </div>
</body>
</html>