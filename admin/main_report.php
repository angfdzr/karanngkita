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

function tambah_laporan_user($data)
{
    global $conn;
    $judul_article = htmlspecialchars($data["judul_article"]);
    $penulis_article = htmlspecialchars($data["penulis_article"]);
    $desk_article = ($data["desk_article"]);

    $gambar_article = upload();
    if (!$gambar_article) {
        return false;
    }

    $query = "INSERT INTO user_article (judul_article, penulis_article, gambar_article, desk_article) VALUES ('$judul_article', '$penulis_article', '$gambar_article', '$desk_article')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES["gambar_article"]["name"];
    $ukuranFile = $_FILES["gambar_article"]["size"];
    $error = $_FILES["gambar_article"]["error"];
    $tmpName = $_FILES["gambar_article"]["tmp_name"];

    if ($error === 4) {
        echo "<script>
                alert('Pilih gambar terlebih dahulu');
              </script>";
        return false;
    }

    // cek apakah file yang di-upload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('Yang Anda unggah bukan gambar');
              </script>";
        return false;
    }

    // cek ukuran gambar
    if ($ukuranFile > 10000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar');
              </script>";
        return false;
    }

    // buat nama baru untuk gambar yang di-upload agar unik
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    // tentukan lokasi folder penyimpanan gambar
    $folderTujuan = '../article/'; // ubah sesuai dengan lokasi folder yang diinginkan

    // pindahkan file gambar ke folder tujuan
    if (move_uploaded_file($tmpName, $folderTujuan . $namaFileBaru)) {
        return 'article/' . $namaFileBaru; // kembalikan path relatif untuk disimpan ke database
    } else {
        echo "<script>
                alert('Gagal mengunggah gambar');
              </script>";
        return false;
    }
}

// cek tombol submit sudah ditekan atau belum
if (isset($_POST["kirim_laporan_user"])) {
    // ambil data dari tiap elemen form
    if (tambah_laporan_user($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'main_report.php'
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'main_report.php'
            </script>";
    }

}

function hapus_admArt($id_adminArticle)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM admin_article WHERE id_adminArticle = $id_adminArticle");

    return mysqli_affected_rows($conn);
}

// Cek apakah parameter id ada
if (isset($_GET["id_adminArticle"])) {
    $id_adminArticle = $_GET["id_adminArticle"];
    if (hapus_admArt($id_adminArticle) > 0) {
        echo "<script>alert('Data berhasil dihapus');
                document.location.href = 'main_report.php';        
        </script>";
    } else {
        echo "<script>alert('Data gagal dihapus');
                document.location.href = 'main_report.php';        
        </script>";
    }
}

function hapus_userArt($id_userArticle)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM user_article WHERE id_userArticle = $id_userArticle");

    return mysqli_affected_rows($conn);
}

// Cek apakah parameter id ada
if (isset($_GET["id_userArticle"])) {
    $id_userArticle = $_GET["id_userArticle"];
    if (hapus_userArt($id_userArticle) > 0) {
        echo "<script>alert('Data berhasil dihapus');
                document.location.href = 'main_report.php';        
        </script>";
    } else {
        echo "<script>alert('Data gagal dihapus');
                document.location.href = 'main_report.php';        
        </script>";
    }
}

$admin_article = query("SELECT * FROM admin_article");
$user_article = query("SELECT * FROM user_article");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Report</title>
    <link rel="stylesheet" href="../admin_styling/report.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
</head>

<body>
    <?php include 'footer_admin.php'; ?>

    <div class="laporan-utama">
        <div class="daftar-laporan">
            <h1 align="middle">Laporan Dari Pengguna</h1>
            <table id="reportTable">
                <thead>
                    <tr>
                        <th>Judul Laporan</th>
                        <th>Penulis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admin_article as $admArt): ?>
                        <tr class="report-row" data-id="<?= $admArt['id_adminArticle'] ?>">
                            <td><?= $admArt['judulAdmin_article'] ?></td>
                            <td><?= $admArt['penulisAdmin_article'] ?></td>
                        </tr>
                        <tr class="report-details" style="display: none;">
                            <td colspan="2">
                                <img src="../<?= $admArt['gambarAdmin_article'] ?>" alt="Gambar Laporan"
                                    style="width: 50%; display: block; margin-bottom: 10px;">
                                <div style="text-align: justify; white-space: pre-wrap;"><?= $admArt['deskAdmin_article'] ?>
                                </div>
                                <a href="?id_adminArticle=<?= $admArt['id_adminArticle'] ?>"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus?')"
                                    style="color: red;">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="buat-artikel">
            <h1>Tambah Laporan</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="penulis_article">Penulis:</label>
                <input type="text" name="penulis_article" id="penulis_article">
                <label for="judul_article">Judul Laporan:</label>
                <input type="text" name="judul_article" id="judul_article">
                <label for="gambar_article">Gambar Pendukung:</label>
                <input type="file" name="gambar_article" id="gambar_article">
                <label for="desk_article">Deskripsi:</label>
                <textarea name="desk_article" id="editor" cols="30" rows="10"></textarea>
                <button type="submit" name="kirim_laporan_user">Kirim</button>
            </form>
        </div>
        <div class="daftar-laporan">
            <h1 align="middle">Total Laporan atau Artikel</h1>
            <table>
                <thead>
                    <th>Judul Laporan</th>
                    <th>Penulis</th>
                </thead>
                <tbody>
                    <?php foreach ($user_article as $userArt): ?>
                        <tr class="article-row" data-id="<?= $userArt['id_userArticle']; ?>">
                            <td><?= $userArt['judul_article']; ?></td>
                            <td><?= $userArt['penulis_article']; ?></td>
                        </tr>
                        <tr class="article-details" id="details-<?= $userArt['id_userArticle']; ?>" style="display: none;">
                            <td colspan="2">
                                <img src="../<?= $userArt['gambar_article']; ?>" alt="" style="width: 50%;">
                                <div style="white-space: pre-wrap; margin-top: 10px;"><?= $userArt['desk_article']; ?></div>
                                <a href="?id_userArticle=<?= $userArt['id_userArticle']; ?>"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus?')"
                                    style="color: red; margin-top: 10px; display: inline-block;">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <div class="container-bottom">
            <p>&copy; 2024 KarangKita. All rights reserved.</p>
        </div>
    </footer>
    <script>
        // JavaScript to toggle details on row click
        document.addEventListener('DOMContentLoaded', () => {
            const rows = document.querySelectorAll('.report-row');
            rows.forEach(row => {
                row.addEventListener('click', () => {
                    const detailsRow = row.nextElementSibling;
                    if (detailsRow.style.display === 'none') {
                        detailsRow.style.display = 'table-row';
                    } else {
                        detailsRow.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <script>
        // Ambil semua baris artikel
        const rows = document.querySelectorAll('.article-row');

        rows.forEach(row => {
            row.addEventListener('click', function () {
                const articleId = this.getAttribute('data-id');
                const detailsRow = document.getElementById(`details-${articleId}`);

                // Toggle visibility dari baris deskripsi
                if (detailsRow.style.display === 'none') {
                    detailsRow.style.display = 'table-row';
                } else {
                    detailsRow.style.display = 'none';
                }
            });
        });
    </script>

    <script type="importmap">
            {
                "imports": {
                    "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.js",
                    "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.1/"
                }
            }
        </script>
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.1/"
            }
        }
    </script>
    <script type="module">
        import {
            ClassicEditor,
            Essentials,
            Paragraph,
            Bold,
            Italic,
            Font,
            Underline,
            Strikethrough,
            List,
            Alignment
        } from 'ckeditor5';
        ClassicEditor
            .create(document.querySelector('#editor'), {
                plugins: [Essentials, Paragraph, Bold, Italic, Font, Underline, Strikethrough, List, Alignment],
                toolbar: [
                    'undo', 'redo', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
                    'bulletedList', 'numberedList', '|', 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                    'alignment'
                ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <!-- A friendly reminder to run on a server, remove this during the integration. -->
    <script>
        window.onload = function () {
            if (window.location.protocol === 'file:') {
                alert('This sample requires an HTTP server. Please serve this file with a web server.');
            }
        };
    </script>
</body>

</html>