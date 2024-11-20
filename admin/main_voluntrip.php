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

function tambah_voluntrip($data)
{
    global $conn;
    $nama_voluntrip = htmlspecialchars($data["nama_voluntrip"]);
    $rekomen_voluntrip = htmlspecialchars($data["rekomen_voluntrip"]);
    $shortdesk_voluntrip = htmlspecialchars($data["shortdesk_voluntrip"]);
    $longdesk_voluntrip = ($data["longdesk_voluntrip"]);
    $owner_voluntrip = htmlspecialchars($data["owner_voluntrip"]);

    // untuk gambar
    $gambar_voluntrip = upload();
    if (!$gambar_voluntrip) {
        return false;
    }

    $query = "INSERT INTO voluntrip (gambar_voluntrip, nama_voluntrip, rekomen_voluntrip, shortdesk_voluntrip, longdesk_voluntrip, owner_voluntrip)
          VALUES ('$gambar_voluntrip', '$nama_voluntrip', '$rekomen_voluntrip', '$shortdesk_voluntrip', '$longdesk_voluntrip', '$owner_voluntrip')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES["gambar_voluntrip"]["name"];
    $ukuranFile = $_FILES["gambar_voluntrip"]["size"];
    $error = $_FILES["gambar_voluntrip"]["error"];
    $tmpName = $_FILES["gambar_voluntrip"]["tmp_name"];

    // cek apakah gambar sudah di-upload atau tidak
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
if (isset($_POST["tambah-voluntrip"])) {
    // ambil data dari tiap elemen form
    if (tambah_voluntrip($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'main_voluntrip.php'
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'main_voluntrip.php'
            </script>";
    }

}

function hapus_voluntrip($id_voluntrip)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM voluntrip WHERE id_voluntrip = $id_voluntrip");

    return mysqli_affected_rows($conn);
}

// Cek apakah parameter id ada
if (isset($_GET["id_voluntrip"])) {
    $id_voluntrip = $_GET["id_voluntrip"];
    if (hapus_voluntrip($id_voluntrip) > 0) {
        echo "<script>alert('Data berhasil dihapus');
                document.location.href = 'main_voluntrip.php';        
        </script>";
    } else {
        echo "<script>alert('Data gagal dihapus');
                document.location.href = 'main_voluntrip.php';        
        </script>";
    }
}


$voluntrip = query("SELECT * FROM voluntrip");
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
            <h1 align="middle">Kelola Halaman Voluntrip</h1><br>
            <form action="" enctype="multipart/form-data" method="post">
                <label for="gambar_voluntrip">Gambar Voluntrip:</label>
                <input type="file" name="gambar_voluntrip" id="gambar_voluntrip">
                <label for="nama_voluntrip">Nama Voluntrip:</label>
                <input type="text" name="nama_voluntrip" id="nama_voluntrip">
                <label for="rekomen_voluntrip">Lokasi:</label>
                <input type="text" name="rekomen_voluntrip" id="rekomen_voluntrip">
                <label for="shortdesk_voluntrip">Deskripsi Singkat:</label>
                <textarea type="text" name="shortdesk_voluntrip" id="shortdesk_voluntrip"></textarea>
                <label for="longdesk_voluntrip">Deskripsi Lengkap:</label>
                <textarea type="text" name="longdesk_voluntrip" id="editor"></textarea><br>
                <label for="owner_voluntrip">Pemilik Voluntrip:</label>
                <input type="text" name="owner_voluntrip" id="owner_voluntrip">
                <button type="submit" name="tambah-voluntrip">Tambah Data Voluntrip</button>
            </form>
        </div>
        <div class="read-menu">
            <h2 align="middle">Daftar Voluntrip</h2>
            <table id="voluntripTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Voluntrip</th>
                        <th>Lokasi</th>
                        <th>Deskripsi Singkat</th>
                        <th>Pemilik</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($voluntrip as $vlt): ?>
                        <tr class="voluntrip-row" data-id="<?= $vlt['id_voluntrip']; ?>">
                            <td><?= $i; ?></td>
                            <td><?= $vlt['nama_voluntrip']; ?></td>
                            <td><?= $vlt['rekomen_voluntrip']; ?></td>
                            <td><?= $vlt['shortdesk_voluntrip']; ?></td>
                            <td><?= $vlt['owner_voluntrip']; ?></td>
                        </tr>
                        <tr class="voluntrip-details" id="details-<?= $vlt['id_voluntrip']; ?>" style="display: none;">
                            <td colspan="5">
                                <img src="../<?= $vlt['gambar_voluntrip']; ?>" alt="Foto Voluntrip" style="width: 50%;">
                                <strong>Deskripsi Lengkap:</strong>
                                <p><?= $vlt['longdesk_voluntrip']; ?></p>
                                <div>
                                    <a href="edit_voluntrip.php?id_voluntrip=<?= $vlt['id_voluntrip']; ?>"
                                        style="margin-right: 10px;">Edit</a>
                                    <a href="?id_voluntrip=<?= $vlt['id_voluntrip']; ?>"
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
            const rows = document.querySelectorAll('.voluntrip-row');
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