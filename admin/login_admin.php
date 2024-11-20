<?php
require '../user/functions.php';

if (isset($_POST["login_admin"])) {
    $user_admin = strtolower(stripslashes($_POST["user_admin"]));
    $pass_admin = $_POST["pass_admin"];

    // Cek apakah username ada dalam database
    $result = mysqli_query($conn, "SELECT * FROM admin WHERE user_admin = '$user_admin'");
    // Jika username ditemukan
    if (mysqli_num_rows($result) === 1) {
        // Ambil data pengguna
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($pass_admin, $row["pass_admin"])) {
            // Jika password benar, bisa login
            // Anda bisa menggunakan session atau cookie di sini untuk menjaga status login
            session_start();
            $_SESSION["login_admin"] = true;
            $_SESSION["user_admin"] = $user_admin;
            
            // Redirect ke halaman dashboard admin
            header("Location: dashboard_admin.php");
            exit;
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../admin_styling/style.css">
</head>
<body>
    <div class="kolom-utama">
        <h1>Login Admin</h1>
        <form action="" method="post">
            <label for="user_admin">Username Admin:</label>
            <input type="text" name="user_admin" id="user_admin" autocomplete="off">
            <label for="pass_admin">Password Admin:</label>
            <input type="password" name="pass_admin" id="pass_admin" autocomplete="off">
            <button type="submit" name="login_admin">Login</button>
            <a href="regis_admin.php">Buat Akun Admin</a>
        </form>
    </div>
</body>
</html>
