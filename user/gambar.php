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

// Ambil hasil prediksi dan path gambar dari URL parameter
$prediction = isset($_GET['prediction']) ? $_GET['prediction'] : '';
$imagePath = isset($_GET['image_path']) ? $_GET['image_path'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KarangKita - Identification</title>
    <link rel="stylesheet" href="../styling/identify.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigasi Bar -->
    <?php include 'nav.php'; ?>
    <div class="kolom-pembungkus">
        <div class="cek">
            <h1>Identifikasi Karang</h1>
            <form action="predict.php" method="POST" enctype="multipart/form-data">
                <label for="image">Unggah Gambar Karang:</label><br><br>
                <input type="file" name="image" accept="image/*" required><br><br>
                <button type="submit">Deteksi</button>
            </form>

            <?php if (isset($_GET['prediction'])): ?>
                <h2>Prediksi: <?php echo htmlspecialchars($_GET['prediction']); ?></h2>
            <?php endif; ?>

            <?php if (isset($_GET['image_path'])): ?>
                <h3>Gambar yang Diupload:</h3>
                <img src="http://localhost:5000<?php echo htmlspecialchars($_GET['image_path']); ?>" alt="Uploaded Image"
                    style="max-width: 500px;">
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>