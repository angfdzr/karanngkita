<?php
session_start();
require 'functions.php';

// Cek apakah session 'username' sudah diset
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login atau tampilkan pesan default
    $username = 'Guest';
} else {
    // Jika sudah login, ambil username dari session
    $username = $_SESSION['username'];
}

$about = query("SELECT * FROM about");
$misi = query("SELECT * FROM misi");
$members = query("SELECT * FROM members");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KarangKita - About Us</title>
    <link rel="stylesheet" href="../styling/about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigasi Bar -->
    <?php include 'nav.php'; ?>

    <div class="bg-header">
        <h1>About Us</h1>
    </div>

    <div class="about-container">
    <section class="about">
            <h2>Tentang KarangKita</h2>
            <?php foreach ($about as $abt): ?>
            <p><?= $abt["desk_about"]; ?></p>
            <?php endforeach; ?>
        </section>

        <section class="mission">
            <h2>Misi Kami</h2>
            <?php foreach ($misi as $ms): ?>
            <ul>
                <li><strong><?= $ms["subjek_misi"] ?>:</strong> <?= $ms["desk_misi"] ?></li>
            </ul>
            <?php endforeach; ?>
        </section>

        <section class="vision">
            <h2>Visi Kami</h2>
            <p><?= $abt["visi"]; ?></p>
        </section>

        <section class="team">
            <h2>Tim Kami</h2>
            <div class="team-members">
                <?php foreach ( $members as $member): ?>
                <div class="member">
                    <img src="../<?= $member["foto_profil"] ?>" alt="Foto Tim" class="team-photo">
                    <h3><?= $member["nama_members"] ?></h3>
                    <p><strong><?= $member["posisi"] ?></strong><br><?= $member["desk_members"] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="contact">
            <h2>Hubungi Kami</h2>
            <p><?= $abt["shortdesk_contact"] ?></p>
            <p><strong>Email:</strong> <a href="<?= $abt["email_contact"]; ?>"><?= $abt["email_contact"]; ?></a></p>
            <p><strong>Telepon:</strong> <?= $abt["tlp_contact"]; ?></p>
            <p><strong>Alamat:</strong> <?= $abt["alamat_contact"]; ?></p>
        </section>
        </div>

    <?php include 'footer.php'; ?>
</body>
</html>