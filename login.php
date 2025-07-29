<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $file = fopen("pengguna.txt", "r");
    $validUser = false;

    while ($line = fgets($file)) {
        list($storedUsername, $storedPassword) = explode(",", trim($line));
        if ($username == $storedUsername && $password == $storedPassword) {
            $_SESSION['logged_in'] = true;
            header("Location: dashboard.php");
            exit;
        }
    }
    
    fclose($file);
    echo "Username atau Password salah!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login Pengguna</h2>
    <form method="post" action="login.php">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
