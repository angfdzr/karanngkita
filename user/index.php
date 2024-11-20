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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KarangKita</title>
    <link rel="stylesheet" href="../styling/index.css">
    <style>
        html {
            scroll-behavior: smooth;
            scroll-padding: 10rem;
        }
        html:focus-within{
            scroll-behavior: smooth !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigasi Bar -->
    <?php include 'nav.php'; ?>
    <div class="bg-hero">
        <div class="content">
            <!-- Konten halaman -->
            <div class="hero">
                <h1>Mari bersama-sama menjaga dan melestarikan terumbu karang Indonesia demi masa depan yang lebih hijau
                    dan lestari.</h1>
                <a class="btn-hero" href="#summary">Lebih Lanjut!</a>
            </div>
        </div>
    </div>
    <div class="summary-content">
        <section class="about-us">
            <video controls>
                <source src="../videos/Video Landing Page.mov" type="video/mp4">
            </video>
            <div class="about" id="summary">
                <h2>Tentang KarangKita</h2>
                <?php foreach ($about as $abt): ?>
                    <p><?= $abt["desk_about"]; ?></p>
                    <a href="about_us.php" class="selengkapnya">Lihat Selengkapnya</a>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="identification">
            <h2>Identification</h2>
            <div class="kontainer">
                <a href="gambar.php">
                    <h1>Take a Pict</h1>
                    <p>Anda dapat mengirimkan gambar kepada sistem untuk dideteksi kondisi terumbu karang.</p>
                </a>
            </div>
            <div class="kontainer">
                <a href="form.php">
                    <h1>Fill a Form</h1>
                    <p>Anda dapat mengisi klasifikasi dari sebuah kondisi terumbu karang untuk diidentifikasi
                        kondisinya.</p>
                </a>
            </div>
        </section>
        <section class="information">
            <h2>Information</h2>
            <div class="kontainer">
                <a href="voluntrip.php">
                    <h1>Voluntrip</h1>
                    <p>Anda dapat mengakses halaman yang berisi kumpulan informasi mengenai adanya kegiatan voluntrip bersama teman-teman pecinta terumbu karang.</p>
                </a>
            </div>
            <div class="kontainer">
                <a href="conservation.php">
                    <h1>Konservasi</h1>
                    <p?>Anda dapat mengakses halaman yang berisi kumpulan informasi mengenai adanya kegiatan konservasi bersama teman-teman pecinta terumbu karang.</p>
                </a>
            </div>
            <div class="kontainer">
                <a href="report.php">
                    <h1>Artikel</h1>
                    <p>Anda dapat mengakses halaman yang berisi kumpulan artikel dan menambah laporan tentang kondisi terumbu karang tertentu.</p>
                </a>
            </div>
        </section>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        document.querySelector('.btn-hero').addEventListener('click', function (event) {
            event.preventDefault();  // Mencegah aksi default (misalnya, menggulir langsung)

            // Ambil elemen tujuan berdasarkan ID
            const target = document.querySelector(this.getAttribute('href'));

            // Gulir ke elemen tersebut dengan animasi halus
            target.scrollIntoView({
                behavior: 'smooth',  // Untuk gulir halus
                block: 'start'       // Agar mulai dari posisi atas elemen
            });
        });
    </script>
</body>

</html>