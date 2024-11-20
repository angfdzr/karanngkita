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

function tambah_konservasi($data)
{
    global $conn;
    $nama_konservasi = htmlspecialchars($data["nama_konservasi"]);
    $lokasi_konservasi = htmlspecialchars($data["lokasi_konservasi"]);
    $shortdesk_konservasi = htmlspecialchars($data["shortdesk_konservasi"]);
    $longdesk_konservasi = ($data["longdesk_konservasi"]);
    $manfaat_konservasi = htmlspecialchars($data["manfaat_konservasi"]);

    $gambar_konservasi = upload();
    if (!$gambar_konservasi) {
        return false;
    }
    $query = "INSERT INTO konservasi (gambar_konservasi, nama_konservasi, lokasi_konservasi, shortdesk_konservasi, longdesk_konservasi, manfaat_konservasi) VALUES ('$gambar_konservasi', '$nama_konservasi', '$lokasi_konservasi', '$shortdesk_konservasi', '$longdesk_konservasi', '$manfaat_konservasi')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES["gambar_konservasi"]["name"];
    $ukuranFile = $_FILES["gambar_konservasi"]["size"];
    $error = $_FILES["gambar_konservasi"]["error"];
    $tmpName = $_FILES["gambar_konservasi"]["tmp_name"];

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
    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar');
              </script>";
        return false;
    }

    // buat nama baru untuk gambar yang di-upload agar unik
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    // tentukan lokasi folder penyimpanan gambar
    $folderTujuan = '../images/'; // ubah sesuai dengan lokasi folder yang diinginkan

    // pindahkan file gambar ke folder tujuan
    if (move_uploaded_file($tmpName, $folderTujuan . $namaFileBaru)) {
        return 'images/' . $namaFileBaru; // kembalikan path relatif untuk disimpan ke database
    } else {
        echo "<script>
                alert('Gagal mengunggah gambar');
              </script>";
        return false;
    }
}

// cek tombol submit sudah ditekan atau belum
if (isset($_POST["tambah-konservasi"])) {
    // ambil data dari tiap elemen form
    if (tambah_konservasi($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'main_conservation.php'
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'main_conservation.php'
            </script>";
    }

}

function hapus_konservasi($id_konservasi)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM konservasi WHERE id_konservasi = $id_konservasi");

    return mysqli_affected_rows($conn);
}

// Cek apakah parameter id ada
if (isset($_GET["id_konservasi"])) {
    $id_konservasi = $_GET["id_konservasi"];
    if (hapus_konservasi($id_konservasi) > 0) {
        echo "<script>alert('Data berhasil dihapus');
                document.location.href = 'main_conservation.php';        
        </script>";
    } else {
        echo "<script>alert('Data gagal dihapus');
                document.location.href = 'main_conservation.php';        
        </script>";
    }
}

$konservasi = query("SELECT * FROM konservasi");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage KarangKita</title>
    <link rel="stylesheet" href="../admin_styling/voluntrip.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
</head>

<body>
    <?php include 'footer_admin.php'; ?>
    <div class="main-menu">
        <div class="add-menu">
            <h1 align="middle">Kelola Halaman Konservasi</h1><br>
            <form action="" enctype="multipart/form-data" method="post">
                <label for="gambar_konservasi">Gambar Konservasi:</label>
                <input type="file" name="gambar_konservasi" id="gambar_konservasi">
                <label for="nama_konservasi">Nama Konservasi:</label>
                <input type="text" name="nama_konservasi" id="nama_konservasi">
                <label for="lokasi_konservasi">Lokasi:</label>
                <input type="text" name="lokasi_konservasi" id="lokasi_konservasi">
                <label for="shortdesk_konservasi">Deskripsi Singkat:</label>
                <textarea type="text" name="shortdesk_konservasi" id="shortdesk_konservasi"></textarea>
                <label for="longdesk_konservasi">Deskripsi Lengkap:</label>
                <textarea type="text" name="longdesk_konservasi" id="editor"></textarea>
                <label for="manfaat_konservasi">Pemilik:</label>
                <input type="text" name="manfaat_konservasi" id="manfaat_konservasi">
                <button type="submit" name="tambah-konservasi">Tambah Data Konservasi</button>
            </form>
        </div>
        <div class="read-menu">
            <h2 align="middle">Daftar Konservasi</h2>
            <table id="konservasiTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Konservasi</th>
                        <th>Lokasi</th>
                        <th>Deskripsi Singkat</th>
                        <th>Pemilik</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($konservasi as $ksr): ?>
                        <tr class="konservasi-row" data-id="<?= $ksr['id_konservasi']; ?>">
                            <td><?= $i; ?></td>
                            <td><?= $ksr['nama_konservasi']; ?></td>
                            <td><?= $ksr['lokasi_konservasi']; ?></td>
                            <td><?= $ksr['shortdesk_konservasi']; ?></td>
                            <td><?= $ksr['manfaat_konservasi']; ?></td>
                        </tr>
                        <tr class="konservasi-details" id="details-<?= $ksr['id_konservasi']; ?>" style="display: none;">
                            <td colspan="5">
                                <img src="../<?= $ksr['gambar_konservasi']; ?>" alt="Foto Konservasi"
                                    style="width: 50%;"><br>
                                <strong>Deskripsi Lengkap:</strong>
                                <p><?= $ksr['longdesk_konservasi']; ?></p>
                                <div>
                                    <a href="edit_konservasi.php?id_konservasi=<?= $ksr['id_konservasi']; ?>"
                                        style="margin-right: 10px;">Edit</a>
                                    <a href="?id_konservasi=<?= $ksr['id_konservasi']; ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; ?>
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
        document.addEventListener('DOMContentLoaded', () => {
            const rows = document.querySelectorAll('.konservasi-row');
            rows.forEach(row => {
                row.addEventListener('click', () => {
                    const detailsRow = document.getElementById(`details-${row.dataset.id}`);
                    if (detailsRow.style.display === 'none') {
                        detailsRow.style.display = 'table-row';
                    } else {
                        detailsRow.style.display = 'none';
                    }
                });
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