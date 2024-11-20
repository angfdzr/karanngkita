<?php
session_start();
require 'functions.php';

// Cek apakah session 'username' sudah diset
if (!isset($_SESSION['username'])) {
    $username = '';
} else {
    $username = $_SESSION['username'];
}
$id_userArticle = $_GET["id"];
$oldArticle = query("SELECT * FROM user_article WHERE id_userArticle = $id_userArticle");

// Ambil 'id' dari URL
$id_userArticle = $_GET['id'];

// Query untuk mendapatkan detail konservasi berdasarkan id
$ksr = query("SELECT * FROM user_article WHERE id_userArticle = $id_userArticle")[0];

if (isset($_POST['kirim_komen'])) {
    // Ambil data dari form
    $id_userArticle = $_POST['id_userArticle'];
    $pengomentar = htmlspecialchars($_POST['pengomentar']);
    $pesan_komentar = htmlspecialchars($_POST['pesan_komentar']);

    // Query untuk menambahkan komentar ke database
    $query = "INSERT INTO komentar (id_userArticle, pengomentar, pesan_komentar) 
              VALUES ('$id_userArticle', '$pengomentar', '$pesan_komentar')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Redirect kembali ke halaman detail konservasi jika berhasil
        header("Location: artikel_detail.php?id=" . $id_userArticle);
        exit;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
$comments = query("SELECT * FROM komentar WHERE id_userArticle = $id_userArticle");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KarangKita - Artikel</title>
    <link rel="stylesheet" href="../styling/report.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="bg-header">
        <h1>Halaman Informasi - Artikel</h1>
    </div>

    <div class="container-article">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul>
                <li>
                    <h2><a href="buat_artikel.php" align="middle">Buat Artikel</a></h2>
                </li>
            </ul>
            <h3>Artikel Terkait</h3>
            <ul>
                <?php foreach ($oldArticle as $artikel): ?>
                    <li>
                        <img src="../<?= htmlspecialchars($artikel['gambar_article']); ?>" width="200px" alt="">
                        <a href="artikel_detail.php?id=<?= $artikel['id_userArticle']; ?>"><?= htmlspecialchars($artikel['judul_article']); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <!-- Konten Artikel -->
        <main class="content">
            <?php if ($artikel): ?>
                <article>
                    <h1><?= htmlspecialchars($artikel['judul_article']); ?></h1>
                    <p class="article-meta">Ditulis oleh
                        <strong><?= htmlspecialchars($artikel['penulis_article']); ?></strong> pada
                        <em><?= htmlspecialchars($artikel['created_at']); ?></em></p>
                    <img src="../<?= htmlspecialchars($artikel['gambar_article']); ?>" alt="Gambar Artikel"
                        class="article-image">
                    <p><div align="justify" style="white-space: pre-wrap;"><?= $artikel["desk_article"] ?></div></p>
                </article>
            <?php else: ?>
                <p>Artikel tidak ditemukan.</p>
            <?php endif; ?>

            <!-- Komentar -->
            <section class="comments-section">
                <h2>Komentar</h2>
                <div class="comment">
                    <?php foreach ($comments as $comment): ?>
                        <p><strong><?= htmlspecialchars($comment['pengomentar']); ?>:</strong> <?= htmlspecialchars($comment['pesan_komentar']); ?></p>
                    <?php endforeach; ?>
                </div>
                <form action="" method="post" class="comment-form">
                    <h3>Tambahkan Komentar</h3>
                    <input type="hidden" name="id_userArticle" value="<?= htmlspecialchars($ksr['id_userArticle']); ?>">
                    <input type="text" name="pengomentar" id="pengomentar" placeholder="Nama Lengkap" autocomplete="off" required>
                    <textarea name="pesan_komentar" id="pesan_komentar" placeholder="Tulis komentar Anda..." required></textarea>
                    <button type="submit" name="kirim_komen">Kirim Komentar</button>
                </form>
            </section>
        </main>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
