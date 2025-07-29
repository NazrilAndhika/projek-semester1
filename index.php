<?php
session_start();

if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $file = fopen('pengguna.txt', 'r');
    $authenticated = false;

    while (($line = fgets($file)) !== false) {
        list($stored_user, $stored_pass) = explode('|', trim($line));
        if ($username === $stored_user && $password === $stored_pass) {
            $authenticated = true;
            $_SESSION['username'] = $username; 
            break;
        }
    }
    fclose($file);

    if (!$authenticated) {
        $error = 'Username atau password salah!'; 
    } else {
        header('Location: dashboard.php'); 
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post">
            <div class="input-group">
                <label for="username">Username: </label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Login</button>
        </form>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <p class="signup-link">Belum punya akun? <a href="buat_akun.php">Buat Akun</a></p>
    </div>
</body>
</html>
