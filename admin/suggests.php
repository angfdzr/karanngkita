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

$saran = query("SELECT * FROM saran");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Information - Suggests</title>
    <link rel="stylesheet" href="../admin_styling/suggests.css">
</head>
<body>
    <?php include 'footer_admin.php'; ?>

    <div class="kolom-utama">
        <div class="kolom-saran">
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <th>No</th>
                    <th>Subjek</th>
                    <th>Pesan</th>
                </thead>
                <?php $i = 1; ?>
                <?php foreach ($saran as $srn): ?>
                <tbody>
                    <td><?= $i; ?></td>
                    <td><?= $srn["subjek"]; ?></td>
                    <td><?= $srn["pesan"]; ?></td>
                </tbody>
                <?php $i++; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <footer>
        <div class="container-bottom">
            <p>&copy; 2024 KarangKita. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>