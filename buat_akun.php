<?php
session_start();

// Cek jika sudah login, arahkan ke dashboard
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validasi form
    if ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok!';
    } elseif (strlen($password) < 6) {
        $error = 'Password harus minimal 6 karakter!';
    } else {
        $file = fopen('pengguna.txt', 'a+');
        $exists = false;

        // Periksa apakah username sudah ada
        while (($line = fgets($file)) !== false) {
            list($existing_user, ) = explode('|', trim($line));
            if ($username === $existing_user) {
                $exists = true;
                break;
            }
        }

        if ($exists) {
            $error = 'Username sudah digunakan!';
        } else {
            // Tambahkan user baru ke file
            fwrite($file, "$username|$password\n");
            $success = 'Akun berhasil dibuat! Silakan login.';
        }

        fclose($file);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="buat_akun.css">
</head>
<body>
    <div class="container">
        <h2 class="title">Buat Akun</h2>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php elseif ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
            <a href="index.php">Login Sekarang</a>
        <?php endif; ?>

        <form method="post">
            <div class="input-group">
                <label for="username">Username: </label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="confirm_password">Konfirmasi Password: </label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Buat Akun</button>
        </form>

        <br><a href="index.php">Sudah punya akun? Login</a>
    </div>
</body>
</html>

