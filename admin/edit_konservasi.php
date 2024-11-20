<?php
session_start();
require '../user/functions.php';

function edit_konservasi($data){
    global $conn;
    $id_konservasi = $data["id_konservasi"];
    $nama_konservasi = htmlspecialchars($data["nama_konservasi"]);
    $lokasi_konservasi = htmlspecialchars($data["lokasi_konservasi"]);
    $shortdesk_konservasi = htmlspecialchars($data["shortdesk_konservasi"]);
    $longdesk_konservasi = ($data["longdesk_konservasi"]);
    $manfaat_konservasi = htmlspecialchars($data["manfaat_konservasi"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    if ($_FILES["gambar_konservasi"]["error"] === 4){
        $gambar_konservasi = $gambarLama;
    } else{
        $gambar_konservasi = upload();
    }

    $query = "UPDATE konservasi SET
                gambar_konservasi = '$gambar_konservasi',
                nama_konservasi = '$nama_konservasi',
                lokasi_konservasi = '$lokasi_konservasi',
                shortdesk_konservasi = '$shortdesk_konservasi',
                longdesk_konservasi = '$longdesk_konservasi',
                manfaat_konservasi = '$manfaat_konservasi'
                WHERE id_konservasi = '$id_konservasi' ";

    mysqli_query ($conn, $query);
    return mysqli_affected_rows($conn);
}

// Pastikan id_konservasi telah diset sebelum digunakan
if (!isset($_GET["id_konservasi"])) {
    echo "ID konservasi tidak ditemukan.";
    exit;
}

$id_konservasi = $_GET["id_konservasi"];
$konservasi = query("SELECT * FROM konservasi WHERE id_konservasi = $id_konservasi")[0];

if(isset($_POST["edit_konservasi"])){
    if (edit_konservasi($_POST) > 0){
        echo "<script>
                alert('Data Berhasil Diubah');
                document.location.href = 'main_conservation.php'
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Diubah');
                document.location.href = 'main_conservation.php'
            </script>";
    }
}

function upload(){
    $namaFile = $_FILES["gambar_konservasi"]["name"];
    $ukuranFile = $_FILES["gambar_konservasi"]["size"];
    $error = $_FILES["gambar_konservasi"]["error"];
    $tmpName = $_FILES["gambar_konservasi"]["tmp_name"];

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit konservasi' Page</title>
    <link rel="stylesheet" href="../admin_styling/voluntrip.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
</head>
<body>
<div class="add-menu">
    <form action="" enctype="multipart/form-data" method="post">
        <input type="hidden" name="id_konservasi" value="<?= $id_konservasi; ?>">
        <input type="hidden" name="gambarLama" value="<?= $konservasi["gambar_konservasi"]; ?>">
        
        <label for="gambar_konservasi">Gambar konservasi:</label>
        <input type="file" name="gambar_konservasi" id="gambar_konservasi">
        
        <label for="nama_konservasi">Nama konservasi:</label>
        <input type="text" name="nama_konservasi" id="nama_konservasi" value="<?= $konservasi["nama_konservasi"]; ?>">
        
        <label for="lokasi_konservasi">Lokasi:</label>
        <input type="text" name="lokasi_konservasi" id="lokasi_konservasi" value="<?= $konservasi["lokasi_konservasi"]; ?>">
        
        <label for="shortdesk_konservasi">Deskripsi Singkat:</label>
        <textarea name="shortdesk_konservasi" id="shortdesk_konservasi"><?= $konservasi["shortdesk_konservasi"]; ?></textarea>
        
        <label for="longdesk_konservasi">Deskripsi Lengkap:</label>
        <textarea name="longdesk_konservasi" id="editor"><?= $konservasi["longdesk_konservasi"]; ?></textarea>
        
        <label for="manfaat_konservasi">Manfaat Konservasi:</label>
        <input type="text" name="manfaat_konservasi" id="manfaat_konservasi" value="<?= $konservasi["manfaat_konservasi"]; ?>">
        
        <button type="submit" name="edit_konservasi">Edit Data konservasi</button>
    </form>
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
</body>
</html>
