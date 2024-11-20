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

$prediction = '';
$kriteria = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kondisiWarna = $_POST['kondisiWarna'];
    $kondisiFisik = $_POST['kondisiFisik'];
    $suhuAir = $_POST['suhuAir'];
    $cahaya = $_POST['cahaya'];
    $kedalaman = $_POST['kedalaman'];
    $ph = $_POST['ph'];

    // Logic untuk Bleaching dan Healthy
    if ($kondisiWarna == "biruTua" || $kondisiWarna == "merah" || $kondisiFisik == "keputihan" || $suhuAir < 25 || $suhuAir > 32 || $cahaya < 100 || $cahaya > 300 || $kedalaman < 5 || $kedalaman > 20 || $ph < 7 || $ph > 9) {
        $prediction = "Bleaching";
        $kriteria = "
        <strong>Kriteria untuk Bleaching:</strong><br>
        - <strong>Kondisi Warna:</strong> Dominan warna putih, biru tua, atau merah (warna yang menunjukkan kehilangan pigmentasi).<br>
        - <strong>Kondisi Fisik:</strong> Ada tanda-tanda keputihan yang signifikan.<br>
        - <strong>Suhu Air:</strong> Suhu di bawah 25°C atau di atas 32°C.<br>
        - <strong>Cahaya:</strong> Intensitas cahaya kurang dari 100 W/m² atau lebih dari 300 W/m².<br>
        - <strong>Kedalaman:</strong> Kedalaman kurang dari 5 meter atau lebih dari 20 meter.<br>
        - <strong>pH Air:</strong> Tidak stabil, bisa sangat rendah (<7) atau sangat tinggi (>9).";
    } else {
        $prediction = "Healthy";
        $kriteria = "
        <strong>Kriteria untuk Healthy:</strong><br>
        - <strong>Kondisi Warna:</strong> Warna cerah dan bervariasi seperti hijau, biru muda, dan oranye.<br>
        - <strong>Kondisi Fisik:</strong> Tidak ada keputihan; terlihat robust dan sehat.<br>
        - <strong>Suhu Air:</strong> Suhu air stabil antara 25°C hingga 30°C.<br>
        - <strong>Cahaya:</strong> Intensitas cahaya yang ideal, antara 100 W/m² hingga 200 W/m².<br>
        - <strong>Kedalaman:</strong> Kedalaman antara 5 hingga 10 meter.<br>
        - <strong>pH Air:</strong> pH air stabil, berkisar antara 8.1 hingga 8.3.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KarangKita - Identification</title>
    <link rel="stylesheet" href="../styling/form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigasi Bar -->
    <?php include 'nav.php' ?>
    <main>
    <form class="coral-form" action="" method="post">
        <h1 class="form-title">Coral Health Prediction Form</h1>

        <label for="kondisiWarna">Warna Karang:</label>
        <select name="kondisiWarna" id="kondisiWarna" class="input-field">
            <option value="biruTua">Biru Tua</option>
            <option value="merah">Merah</option>
            <option value="hijau">Hijau</option>
            <option value="ungu">Ungu</option>
            <option value="biruMuda">Biru Muda</option>
            <option value="oren">Orange</option>
        </select>

        <label for="kondisiFisik">Fisik Karang:</label>
        <select name="kondisiFisik" id="kondisiFisik" class="input-field">
            <option value="nonkeputihan">Tidak Ada Keputihan</option>
            <option value="keputihan">Ada Keputihan</option>
        </select>

        <label for="suhuAir">Suhu Air Laut (°C):</label>
        <input type="number" name="suhuAir" id="suhuAir" step="0.1" class="input-field">

        <label for="cahaya">Cahaya Matahari (W/m²):</label>
        <input type="number" name="cahaya" id="cahaya" step="0.1" class="input-field">

        <label for="kedalaman">Kedalaman Laut (m):</label>
        <input type="number" name="kedalaman" id="kedalaman" step="0.1" class="input-field">

        <label for="ph">Ph Air:</label>
        <input type="number" name="ph" id="ph" step="0.1" class="input-field">

        <?php if (!isset($_SESSION['username'])): ?>
            <button type="button" class="btn-predict" onclick="alert('Silakan login terlebih dahulu untuk menggunakan fitur ini.');">Predict Coral Health</button>
        <?php else: ?>
            <button type="submit" class="btn-predict">Predict Coral Health</button>
        <?php endif; ?>
    </form>

    <hr class="divider">

    <div class="result-container">
        <h1>Hasil Prediksi Kesehatan Terumbu Karang</h1>
        <p><strong>Prediksi:</strong> <?= $prediction ?></p>
        <div><?= $kriteria ?></div>
        <div>
            <?php if ($prediction): ?>
                <h2>Deskripsi Hasil:</h2>
                <?php if ($prediction == "Bleaching"): ?>
                    <p>
                        <strong>Bleaching</strong> adalah kondisi di mana terumbu karang kehilangan warna dan kesehatan
                        akibat stres lingkungan, biasanya disebabkan oleh suhu air yang ekstrem, pencemaran, dan kondisi lainnya.
                    </p>
                <?php else: ?>
                    <p>
                        <strong>Healthy</strong> menandakan bahwa terumbu karang berada dalam kondisi baik dan sehat.
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

    <?php include 'footer.php' ?>
</body>
</html>
