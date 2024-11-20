<?php
session_start();
require 'functions.php';
// cek cookie
if (isset($_COOKIE["id"]) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username dari id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    // cek username
    if (mysqli_num_rows($result) === 1) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // set session
            $_SESSION["login"] = true;
            $_SESSION['username'] = $username;

            // cek remember me
            if (isset($_POST["remember"])) {
                // cek cookie
                setcookie('id', $row['id'], time() + 60);
                setcookie('key', hash('sha256', $row['username']), time() + 60);
            }
            header("Location: index.php");
            exit;
        }
        $error = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="../styling/style.css">
</head>

<body>
    <div class="container">
    <div class="logo"><img src="../img/logo.jpg" alt="Logo"></div>
        <h1 class="login">Halaman Login</h1>
        <?php if (isset($error)): ?>
            <p class="note"><i style="color: red;">Username atau Password Salah</i></p>
        <?php endif; ?>
        <div class="form-container">
            <form action="" method="post">
                <ul>
                    <li>
                        <label for="username">Username: </label>
                        <input type="text" name="username" id="username" required autocomplete="off">
                    </li>
                    <li>
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password" required>
                    </li>
                    <li class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember Me</label>
                    </li>
                    <li><button type="submit" name="login">Login</button></li>
                    <li><a href="registrasi.php">Belum Punya Akun? Silahkan Registrasi</a></li>
                </ul>
            </form>
        </div>
    </div>
</body>

</html>