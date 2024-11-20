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
// Ambil 'id' dari URL
$id_konservasi = $_GET['id'];

// Query untuk mendapatkan detail konservasi berdasarkan id
$ksr = query("SELECT * FROM konservasi WHERE id_konservasi = $id_konservasi")[0];

if (isset($_POST['kirim_komen'])) {
    // Ambil data dari form
    $id_konservasi = $_POST['id_konservasi'];
    $pengomentar = htmlspecialchars($_POST['pengomentar']);
    $pesan_komentar = htmlspecialchars($_POST['pesan_komentar']);

    // Query untuk menambahkan komentar ke database
    $query = "INSERT INTO komentar (id_konservasi, pengomentar, pesan_komentar) 
              VALUES ('$id_konservasi', '$pengomentar', '$pesan_komentar')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Redirect kembali ke halaman detail konservasi jika berhasil
        echo "<script>
        alert('Komentar Berhasil Ditambahkan');
        document.location.href = 'conservation_detail.php?id=$id_konservasi';
      </script>";

    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
$comments = query("SELECT * FROM komentar WHERE id_konservasi = $id_konservasi");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KarangKita - Konservasi</title>
    <link rel="stylesheet" href="../styling/voluntrip.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigasi Bar -->
    <?php include 'nav.php'; ?>

    <div class="bg-header">
        <h1>Halaman Informasi - Konservasi</h1>
    </div>

    <div class="voluntrip-detail-container">
        <div class="voluntrip-card">
            <div class="kolom-voluntrip">
                <img class="voluntrip-image" src="../<?= $ksr["gambar_konservasi"]; ?>" alt="<?= $ksr["nama_konservasi"]; ?>"> 
                <div class="voluntrip-content">
                    <h3><?= $ksr["nama_konservasi"]; ?></h3>
                    <div align="justify" style="white-space: pre-wrap;"><?= $ksr["longdesk_konservasi"]; ?></div>
                </div>
            </div>
            <a class="join-button" href="">Ayo Bergabung</a>
            <div class="kolom-sidebar-komentar">
                <h4>Komentar</h4>
                <!-- Section for comments -->
                <div class="comments-section">
                    <?php foreach ($comments as $comment): ?>
                        <p><strong><?= htmlspecialchars($comment['pengomentar']); ?>:</strong> <?= htmlspecialchars($comment['pesan_komentar']); ?></p>
                    <?php endforeach; ?>
                     <h4>Tambah Komentar</h4>
                     <form action="" method="post">
                        <input type="hidden" name="id_konservasi" value="<?= $id_konservasi; ?>">
                        <input type="text" name="pengomentar" id="pengomentar" placeholder="Nama Lengkap" autocomplete="off" required>
                        <textarea name="pesan_komentar" id="pesan_komentar" placeholder="Tulis Komentar Anda..." required></textarea>
                        <?php if (!isset($_SESSION['username'])): ?>
                            <button type="button" onclick="alert('Silakan login terlebih dahulu untuk menggunakan fitur ini.');">Kirim</button>
                        <?php else: ?>
                        <button type="submit" name="kirim_komen">Kirim</button>
                        <?php endif; ?>
                     </form>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>