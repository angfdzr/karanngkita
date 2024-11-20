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

$konservasi = query("SELECT * FROM konservasi");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KarangKita - konservasi</title>
    <link rel="stylesheet" href="../styling/conservation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigasi Bar -->
    <?php include 'nav.php'; ?>
    <div class="bg-header">
        <h1>Halaman Informasi - Conservation</h1>
    </div>

    <section class="blog-articles">
    <!-- Article 1 -->
    <?php $i = 1 ?>
    <?php foreach($konservasi as $ksr): ?>
    <div class="article-card">
        <div class="article-image">
        <img src="../<?= $ksr["gambar_konservasi"]; ?>">
        </div>
        <div class="article-content">
            <a href="conservation_detail.php?id=<?= $ksr['id_konservasi']; ?>"><h2><?= $ksr["nama_konservasi"]; ?></h2></a>
            <p><strong><?= $ksr["lokasi_konservasi"]; ?></strong></p>
            <p><?= $ksr["shortdesk_konservasi"]; ?>...</p>
            <span class="author"><?= $ksr["manfaat_konservasi"]; ?></span><span class="timestamp">dibuat pada <?= $ksr["waktu_konservasi"]; ?></span>
        </div>
    </div>
    <?php $i++; ?>
    <?php endforeach; ?>
</section>
<?php include 'footer.php'; ?>
</body>
</html>