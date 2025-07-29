<?php
// Menyimpan pesan untuk ditampilkan ke pengguna
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idBarang = $_POST['id_barang']; // ID Barang dari input
    $namaBarang = $_POST['nama_barang']; // Nama Barang
    $harga = $_POST['harga']; // Harga Barang
    $stok = $_POST['stok']; // Stok Barang

    // Membaca data barang dari file barang.txt
    $barangs = file('barang.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Validasi apakah Nama Barang sudah ada
    $nameExists = false; // Flag untuk mengecek apakah Nama Barang sudah ada
    foreach ($barangs as $barang) {
        $data = explode(',', $barang); // Pisahkan data per kolom
        if (strcasecmp($data[1], $namaBarang) === 0) { // Periksa Nama Barang (case-insensitive)
            $nameExists = true;
            break;
        }
    }

    if ($nameExists) {
        // Jika Nama Barang sudah ada, tampilkan pesan error
        $message = "Nama Barang '$namaBarang' sudah ada. Jika ingin merubah data saja pindah ke halaman utama, kemudian pilih <i>Ubah Data Barang</i>.";
    } else {
        // Jika Nama Barang belum ada, tambahkan data ke file barang.txt
        $data = "$idBarang,$namaBarang,$harga,$stok" . PHP_EOL;
        file_put_contents('barang.txt', $data, FILE_APPEND); // Menambahkan data ke file
        $message = "Barang berhasil ditambahkan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="tambah_barang.css">
</head>
<body>
    <div class="container">
        <h1>Tambah Barang</h1>

        <!-- Tampilkan pesan jika ada -->
        <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'berhasil') !== false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <!-- Form untuk menambah barang -->
        <form method="post">
            <label for="id_barang">ID Barang:</label>
            <input type="text" name="id_barang" id="id_barang" required><br>

            <label for="nama_barang">Nama Barang:</label>
            <input type="text" name="nama_barang" id="nama_barang" required><br>

            <label for="harga">Harga:</label>
            <input type="number" name="harga" id="harga" required><br>

            <label for="stok">Stok:</label>
            <input type="number" name="stok" id="stok" required><br>

            <button type="submit">Tambah Barang</button>
        </form>
        <a href="dashboard.php">Kembali ke Menu Utama</a>
    </div>
</body>
</html>
