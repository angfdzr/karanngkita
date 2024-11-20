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

$comments_voluntrip = query("SELECT * FROM komentar WHERE id_voluntrip IS NOT NULL");
$comments_konservasi = query("SELECT * FROM komentar WHERE id_konservasi IS NOT NULL");

// Cek jika ada permintaan untuk menghapus komentar
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Query untuk menghapus komentar dari database
    $deleteSql = "DELETE FROM komentar WHERE id_komentar = ?";
    $stmt = $conn->prepare($deleteSql);

    if ($stmt === false) {
        die('Query gagal: ' . $conn->error);  // Menangani error jika prepare gagal
    }

    // Bind parameter dan eksekusi statement
    $stmt->bind_param('i', $delete_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Komentar berhasil dihapus');
                document.location.href = 'komentar.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus komentar');
                document.location.href = 'komentar.php';
              </script>";
    }
}

// Query untuk mengambil semua komentar dari database
$sql = "SELECT * FROM komentar WHERE id_userArticle ORDER BY waktu DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Commentars</title>
    <link rel="stylesheet" href="../admin_styling/komentar.css">
</head>

<body>
    <?php include 'footer_admin.php'; ?>
    <div class="kolom-komentar">
        <h1>Kelola Komentar</h1>

        <div class="komentar-voluntrip">
            <h2>Halaman Voluntrip</h2>
            <table class="comment-table">
                <thead class="table-header">
                    <tr>
                        <th>Penulis</th>
                        <th>Isi Komentar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments_voluntrip as $comment): ?>
                        <tr class="table-row">
                            <td><?= htmlspecialchars($comment['pengomentar']); ?></td>
                            <td><?= htmlspecialchars($comment['pesan_komentar']); ?></td>
                            <td><a href="?delete_id=<?= $comment['id_komentar']; ?>" class="action-link" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">Hapus Komen</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="komentar-konservasi">
            <h2>Halaman Konservasi</h2>
            <table class="comment-table">
                <thead class="table-header">
                    <tr>
                        <th>Penulis</th>
                        <th>Isi Komentar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments_konservasi as $comment): ?>
                        <tr class="table-row">
                            <td><?= htmlspecialchars($comment['pengomentar']); ?></td>
                            <td><?= htmlspecialchars($comment['pesan_komentar']); ?></td>
                            <td><a href="?delete_id=<?= $comment['id_komentar']; ?>" class="action-link"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">Hapus Komen</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="komentar-artikel">
            <h2>Halaman Laporan</h2>
            <table class="comment-table">
                <thead class="table-header">
                    <tr>
                        <th>Penulis</th>
                        <th>Isi Komentar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <!-- Menampilkan komentar -->
                        <?php while ($comment = $result->fetch_assoc()): ?>
                            <tr class="table-row">
                                <td><?= htmlspecialchars($comment['pengomentar']); ?></td>
                                <td><?= nl2br(htmlspecialchars($comment['pesan_komentar'])); ?></td>
                                <td><a href="?delete_id=<?= $comment['id_komentar']; ?>" class="action-link"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">Hapus</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
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
