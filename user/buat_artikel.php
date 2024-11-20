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

function tambah_laporan($data)
{
    global $conn;
    $judulAdmin_article = htmlspecialchars($data["judulAdmin_article"]);
    $penulisAdmin_article = htmlspecialchars($data["penulisAdmin_article"]);
    $deskAdmin_article = ($data["deskAdmin_article"]);

    $gambarAdmin_article = upload();
    if (!$gambarAdmin_article) {
        return false;
    }

    $query = "INSERT INTO admin_article (judulAdmin_article, penulisAdmin_article, gambarAdmin_article, deskAdmin_article) VALUES ('$judulAdmin_article', '$penulisAdmin_article', '$gambarAdmin_article', '$deskAdmin_article')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES["gambarAdmin_article"]["name"];
    $ukuranFile = $_FILES["gambarAdmin_article"]["size"];
    $error = $_FILES["gambarAdmin_article"]["error"];
    $tmpName = $_FILES["gambarAdmin_article"]["tmp_name"];

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
if (isset($_POST["kirim_laporan"])) {
    // ambil data dari tiap elemen form
    if (tambah_laporan($_POST) > 0) {
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

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan</title>
    <link rel="stylesheet" href="../styling/report.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="kolom-artikel">
        <div class="buat-artikel">
            <h1>Buat Artikel</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="penulisAdmin_article">Penulis:</label>
                <input type="text" name="penulisAdmin_article" id="penulisAdmin_article" autocomplete="off" required>
                <label for="judulAdmin_article">Judul Laporan:</label>
                <input type="text" name="judulAdmin_article" id="judulAdmin_article" autocomplete="off" required>
                <label for="gambarAdmin_article">Gambar Pendukung:</label>
                <input type="file" name="gambarAdmin_article" id="gambarAdmin_article" required>
                <label for="deskAdmin_article">Deskripsi:</label >
                <textarea name="deskAdmin_article" id="editor" cols="30" rows="10"></textarea>
                <?php if (!isset($_SESSION['username'])): ?>
                    <button type="button"
                        onclick="alert('Silakan login terlebih dahulu untuk menggunakan fitur ini.');">Kirim</button>
                <?php else: ?>
                    <button type="submit" name="kirim_laporan">Kirim</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
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
    <?php include 'footer.php'; ?>
</body>

</html>