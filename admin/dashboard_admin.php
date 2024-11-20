<?php
session_start();
require '../user/functions.php';

// Cek apakah session 'username' sudah diset
if (!isset($_SESSION['user_admin'])) {
    // Jika belum login, arahkan ke halaman login atau tampilkan pesan default
    $user_admin = 'Guest';
} else {
    // Jika sudah login, ambil username dari session
    $user_admin = $_SESSION['user_admin'];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage KarangKita</title>
    <link rel="stylesheet" href="../admin_styling/admin.css">
</head>

<body>
    <?php include 'footer_admin.php'; ?>
    <div class="hero">
        <h1>Selamat Datang di Sistem Pengelolaan Website KarangKita, <?= $user_admin ?></h1>
    </div>

    <footer>
        <div class="container-bottom">
            <p>&copy; 2024 KarangKita. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>