<?php
session_start();
require 'functions.php';

// Cek apakah session 'username' sudah diset
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login atau tampilkan pesan default
    $username = '';
} else {
    // Jika sudah login, ambil username dari session
    $username = $_SESSION['username'];
}
$voluntrip = query("SELECT * FROM voluntrip");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KarangKita - Voluntrip</title>
    <link rel="stylesheet" href="../styling/voluntrip.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigasi Bar -->
    <?php include 'nav.php'; ?>

    <div class="bg-header">
        <h1>Halaman Informasi - Voluntrip</h1>
    </div>

    <section class="blog-articles">
    <!-- Article 1 -->
    <?php $i = 1 ?>
    <?php foreach($voluntrip as $vlt): ?>
    <div class="article-card">
        <div class="article-image">
        <img src="../<?= $vlt["gambar_voluntrip"]; ?>">
        </div>
        <div class="article-content">
            <a href="voluntrip_detail.php?id=<?= $vlt['id_voluntrip']; ?>"><h2><?= $vlt["nama_voluntrip"]; ?></h2></a>
            <p><strong><?= $vlt["rekomen_voluntrip"]; ?></strong></p>
            <p><?= $vlt["shortdesk_voluntrip"]; ?>...</p>
            <span class="author"><?= $vlt["owner_voluntrip"]; ?></span><span class="timestamp"><?= $vlt["dibuat_voluntrip"]; ?></span>
        </div>
    </div>
    <?php $i++; ?>
    <?php endforeach; ?>
</section>

    <?php include 'footer.php'; ?>
</body>
</html>