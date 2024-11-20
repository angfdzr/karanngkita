<?php
session_start();
require 'functions.php';

// Cek apakah session 'username' sudah diset
if (!isset($_SESSION['username'])) {
    $username = '';
} else {
    $username = $_SESSION['username'];
}

// Query untuk mengambil artikel terbaru
$newSql = "SELECT * FROM user_article ORDER BY created_at DESC";
$newArticleResult = $conn->query($newSql);
$newArticle = $newArticleResult->fetch_assoc(); // Mengambil satu artikel terbaru

// Query untuk mengambil artikel lebih lama
$oldSql = "SELECT * FROM user_article ORDER BY created_at ASC";
$oldArticleResult = $conn->query($oldSql);
$oldArticle = $oldArticleResult->fetch_all(MYSQLI_ASSOC); // Mengambil semua artikel lama

// Cek apakah form komentar disubmit
if (isset($_POST['buat_komen'])) {
    $id_userArticle = $_POST['id_userArticle'];
    $pengomentar = $_POST['pengomentar'];
    $pesan_komentar = $_POST['pesan_komentar'];

    // Cek apakah koneksi database berhasil
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mengecek apakah komentar sudah ada untuk artikel dan pengomentar yang sama
    $checkSql = "SELECT * FROM komentar WHERE id_userArticle = ? AND pengomentar = ? AND pesan_komentar = ?";

    // Persiapkan statement
    $stmt = $conn->prepare($checkSql);

    if ($stmt === false) {
        die('Query gagal: ' . $conn->error);  // Menangani error jika prepare gagal
    }

    // Bind parameter ke statement
    $stmt->bind_param('iss', $id_userArticle, $pengomentar, $pesan_komentar);

    // Eksekusi statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Jika komentar belum ada, masukkan komentar ke dalam database
        $insertSql = "INSERT INTO komentar (id_userArticle, pengomentar, pesan_komentar) VALUES (?, ?, ?)";

        // Persiapkan statement untuk insert
        $stmt = $conn->prepare($insertSql);

        if ($stmt === false) {
            die('Query gagal: ' . $conn->error);  // Menangani error jika prepare gagal
        }

        // Bind parameter ke statement
        $stmt->bind_param('iss', $id_userArticle, $pengomentar, $pesan_komentar);

        // Eksekusi statement
        if ($stmt->execute()) {
            echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'report.php'
            </script>";
        } else {
            echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'report.php'
            </script>";
        }
    } else {
        echo "Komentar ini sudah ada!";
    }
}

// Query untuk mengambil komentar terkait artikel ini
$commentSql = "SELECT * FROM komentar WHERE id_userArticle = ? ORDER BY waktu DESC";
$stmt = $conn->prepare($commentSql);

if ($stmt === false) {
    die('Query gagal: ' . $conn->error);  // Menangani error jika prepare gagal
}

// Bind parameter
$stmt->bind_param('i', $newArticle['id_userArticle']);
$stmt->execute();
$commentResult = $stmt->get_result();



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
                        <a
                            href="artikel_detail.php?id=<?= $artikel['id_userArticle']; ?>"><?= htmlspecialchars($artikel['judul_article']); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <!-- Konten Artikel Utama -->
        <main class="content">
            <?php if (isset($newArticle) && $newArticle): ?>
                <article>
                    <h1><?= htmlspecialchars($newArticle['judul_article'] ?? 'Judul tidak tersedia'); ?></h1>
                    <p class="article-meta">Ditulis oleh
                        <strong><?= htmlspecialchars($newArticle['penulis_article'] ?? 'Penulis tidak diketahui'); ?></strong>
                        pada
                        <em><?= htmlspecialchars($newArticle['created_at'] ?? 'Tanggal tidak tersedia'); ?></em>
                    </p>
                    <img src="../<?= htmlspecialchars($newArticle['gambar_article'] ?? ''); ?>" alt="Gambar Artikel"
                        class="article-image">
                    <div align="justify" style="white-space: pre-wrap;">
                        <?= ($newArticle['desk_article'] ?? 'Deskripsi tidak tersedia'); ?>
                    </div>
                </article>
            <?php else: ?>
                <p>Belum ada artikel terbaru.</p>
            <?php endif; ?>

            <!-- Komentar -->
            <section class="comments-section">
                <h2>Komentar</h2>
                <?php if ($commentResult->num_rows > 0): ?>
                    <!-- Menampilkan komentar -->
                    <?php while ($comment = $commentResult->fetch_assoc()): ?>
                        <div class="comment">
                            <p><strong><?= htmlspecialchars($comment['pengomentar']); ?>:</strong>
                                <?= nl2br(htmlspecialchars($comment['pesan_komentar'])); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Belum ada komentar.</p>
                <?php endif; ?>
                <form action="" method="post" class="comment-form">
                    <h3>Tambahkan Komentar</h3>
                    <input type="hidden" name="id_userArticle"
                        value="<?= htmlspecialchars($newArticle['id_userArticle']); ?>">
                    <input type="text" name="pengomentar" id="pengomentar" placeholder="Nama Lengkap" autocomplete="off" required>
                    <textarea name="pesan_komentar" id="pesan_komentar" placeholder="Tulis komentar Anda..."
                        required></textarea>
                        <?php if (!isset($_SESSION['username'])): ?>
                            <button type="button" onclick="alert('Silakan login terlebih dahulu untuk menggunakan fitur ini.');">Kirim Komentar</button>
                        <?php else: ?>
                    <button type="submit" name="buat_komen">Kirim Komentar</button>
                    <?php endif; ?>
                </form>
            </section>
        </main>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>