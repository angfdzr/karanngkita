<?php
session_start();
require '../user/functions.php';

function edit_voluntrip($data){
    global $conn;
    $id_voluntrip = $data["id_voluntrip"];
    $nama_voluntrip = htmlspecialchars($data["nama_voluntrip"]);
    $rekomen_voluntrip = htmlspecialchars($data["rekomen_voluntrip"]);
    $shortdesk_voluntrip = htmlspecialchars($data["shortdesk_voluntrip"]);
    $longdesk_voluntrip = ($data["longdesk_voluntrip"]);
    $owner_voluntrip = htmlspecialchars($data["owner_voluntrip"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    if ($_FILES["gambar_voluntrip"]["error"] === 4){
        $gambar_voluntrip = $gambarLama;
    } else{
        $gambar_voluntrip = upload();
    }

    $query = "UPDATE voluntrip SET
                gambar_voluntrip = '$gambar_voluntrip',
                nama_voluntrip = '$nama_voluntrip',
                rekomen_voluntrip = '$rekomen_voluntrip',
                shortdesk_voluntrip = '$shortdesk_voluntrip',
                longdesk_voluntrip = '$longdesk_voluntrip',
                owner_voluntrip = '$owner_voluntrip'
                WHERE id_voluntrip = '$id_voluntrip' ";

    mysqli_query ($conn, $query);
    return mysqli_affected_rows($conn);
}

// Pastikan id_voluntrip telah diset sebelum digunakan
if (!isset($_GET["id_voluntrip"])) {
    echo "ID Voluntrip tidak ditemukan.";
    exit;
}

$id_voluntrip = $_GET["id_voluntrip"];
$voluntrip = query("SELECT * FROM voluntrip WHERE id_voluntrip = $id_voluntrip")[0];

if(isset($_POST["edit_voluntrip"])){
    if (edit_voluntrip($_POST) > 0){
        echo "<script>
                alert('Data Berhasil Diubah');
                document.location.href = 'main_voluntrip.php'
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Diubah');
                document.location.href = 'main_voluntrip.php'
            </script>";
    }
}

function upload(){
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Voluntrip' Page</title>
    <link rel="stylesheet" href="../admin_styling/voluntrip.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
</head>
<body>
<div class="add-menu">
    <form action="" enctype="multipart/form-data" method="post">
        <input type="hidden" name="id_voluntrip" value="<?= $id_voluntrip; ?>">
        <input type="hidden" name="gambarLama" value="<?= $voluntrip["gambar_voluntrip"]; ?>">
        
        <label for="gambar_voluntrip">Gambar Voluntrip:</label>
        <input type="file" name="gambar_voluntrip" id="gambar_voluntrip">
        
        <label for="nama_voluntrip">Nama Voluntrip:</label>
        <input type="text" name="nama_voluntrip" id="nama_voluntrip" value="<?= $voluntrip["nama_voluntrip"]; ?>">
        
        <label for="rekomen_voluntrip">Level:</label>
        <input type="text" name="rekomen_voluntrip" id="rekomen_voluntrip" value="<?= $voluntrip["rekomen_voluntrip"]; ?>">
        
        <label for="shortdesk_voluntrip">Deskripsi Singkat:</label>
        <textarea name="shortdesk_voluntrip" id="shortdesk_voluntrip"><?= $voluntrip["shortdesk_voluntrip"]; ?></textarea>
        
        <label for="longdesk_voluntrip">Deskripsi Lengkap:</label>
        <textarea name="longdesk_voluntrip" id="editor"><?= $voluntrip["longdesk_voluntrip"]; ?></textarea>
        
        <label for="owner_voluntrip">Pemilik Voluntrip:</label>
        <input type="text" name="owner_voluntrip" id="owner_voluntrip" value="<?= $voluntrip["owner_voluntrip"]; ?>">
        
        <button type="submit" name="edit_voluntrip">Edit Data Voluntrip</button>
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
