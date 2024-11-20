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

function add_menu_1($data)
{
    global $conn;
    $desk_about = htmlspecialchars($data["desk_about"]);
    $visi = htmlspecialchars($data["visi"]);
    $shortdesk_contact = htmlspecialchars($data["shortdesk_contact"]);
    $email_contact = htmlspecialchars($data["email_contact"]);
    $tlp_contact = htmlspecialchars($data["tlp_contact"]);
    $alamat_contact = htmlspecialchars($data["alamat_contact"]);

    $query = "INSERT INTO about (desk_about, visi, shortdesk_contact, email_contact, tlp_contact, alamat_contact) VALUES ('$desk_about', '$visi', '$shortdesk_contact', '$email_contact', '$tlp_contact', '$alamat_contact')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function add_menu_2($data){
    global $conn;
    $subjek_misi = htmlspecialchars($data["subjek_misi"]);
    $desk_misi = htmlspecialchars($data["desk_misi"]);
    $query = "INSERT INTO misi (subjek_misi, desk_misi) VALUES ('$subjek_misi', '$desk_misi')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function add_menu_3($data){
    global $conn;
    $nama_members = htmlspecialchars($data["nama_members"]);
    $posisi = htmlspecialchars($data["posisi"]);
    $desk_members = htmlspecialchars($data["desk_members"]);
    $foto_profil = upload();
    if(!$foto_profil){
        return false;
    }
    $query = "INSERT INTO members (foto_profil, nama_members, posisi, desk_members) VALUES ('$foto_profil', '$nama_members', '$posisi', '$desk_members')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload(){
    $namaFile = $_FILES["foto_profil"]["name"];
    $ukuranFile = $_FILES["foto_profil"]["size"];
    $error = $_FILES["foto_profil"]["error"];
    $tmpName = $_FILES["foto_profil"]["tmp_name"];

    if ($error === 4){
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

if (isset($_POST["tambah-about"])) {
    if (add_menu_1($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'about.php'
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'about.php'
            </script>";
    }
}

if (isset($_POST["add-misi"])) {
    if (add_menu_2($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'about.php'
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'about.php'
            </script>";
    }
}

if (isset($_POST["add-members"])) {
    if (add_menu_3($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'about.php'
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'about.php'
            </script>";
    }
}

function hapus_about($id_about){
    global $conn;
    mysqli_query( $conn,"DELETE FROM about WHERE id_about = $id_about");

    return mysqli_affected_rows( $conn );
}

// Cek apakah parameter id ada
if (isset($_GET["id_about"])) {
    $id_about = $_GET["id_about"];
    if (hapus_about($id_about) > 0) {
        echo "<script>alert('Data berhasil dihapus');
                document.location.href = 'about.php';        
        </script>";
    } else {
        echo "<script>alert('Data gagal dihapus');
                document.location.href = 'about.php';        
        </script>";
    }
}
function hapus_misi($id_misi){
    global $conn;
    mysqli_query( $conn,"DELETE FROM misi WHERE id_misi = $id_misi");

    return mysqli_affected_rows( $conn );
}

// Cek apakah parameter id ada
if (isset($_GET["id_misi"])) {
    $id_misi = $_GET["id_misi"];
    if (hapus_misi($id_misi) > 0) {
        echo "<script>alert('Data berhasil dihapus');
                document.location.href = 'about.php';        
        </script>";
    } else {
        echo "<script>alert('Data gagal dihapus');
                document.location.href = 'about.php';        
        </script>";
    }
}
function hapus_members($id_members){
    global $conn;
    mysqli_query( $conn,"DELETE FROM members WHERE id_members = $id_members");

    return mysqli_affected_rows( $conn );
}

// Cek apakah parameter id ada
if (isset($_GET["id_members"])) {
    $id_members = $_GET["id_members"];
    if (hapus_members($id_members) > 0) {
        echo "<script>alert('Data berhasil dihapus');
                document.location.href = 'about.php';        
        </script>";
    } else {
        echo "<script>alert('Data gagal dihapus');
                document.location.href = 'about.php';        
        </script>";
    }
}

$about = query("SELECT * FROM about");
$misi = query("SELECT * FROM misi");
$members = query("SELECT * FROM members");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage KarangKita</title>
    <link rel="stylesheet" href="../admin_styling/about.css">
</head>

<body>
    <?php include 'footer_admin.php'; ?>
    <div class="kolom-utama">
        <div class="add-menu">
            <h1>Kelola About Us</h1>
            <form action="" method="post">
                <label for="desk_about">Deskripsi:</label>
                <textarea name="desk_about" id="desk_about"></textarea>

                <label for="visi">Visi:</label>
                <textarea name="visi" id="visi"></textarea>

                <label for="shortdesk_contact">Deskripsi Bagian Kontak:</label>
                <textarea name="shortdesk_contact" id="shortdesk_contact"></textarea>

                <label for="email_contact">Email Contact:</label>
                <input type="email" name="email_contact" id="email_contact">

                <label for="tlp_contact">Kontak No Telepon:</label>
                <input type="text" name="tlp_contact" id="tlp_contact">

                <label for="alamat_contact">Alamat:</label>
                <textarea name="alamat_contact" id="alamat_contact"></textarea>

                <button type="submit" name="tambah-about">Tambah</button>
            </form>
            <div class="add-menu">
                <form action="" method="post">
                    <label for="subjek_misi">Subjek Misi:</label>
                    <input type="text" name="subjek_misi" id="subjek_misi">
                    <label for="desk_misi">Deskripsi Misi:</label>
                    <textarea name="desk_misi" id="desk_misi"></textarea>
                    <button type="submit" name="add-misi">Tambah Misi</button>
                </form>
            </div>
            <div class="add-members">
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="foto_profil">Foto Profil:</label>
                    <input type="file" name="foto_profil" id="foto_profil">

                    <label for="nama_members">Nama Anggota:</label>
                    <input type="text" name="nama_members" id="nama_members">

                    <label for="posisi">Posisi:</label>
                    <input type="text" name="posisi" id="posisi">

                    <label for="desk_members">Deskripsi Anggota:</label>
                    <textarea name="desk_members" id="desk_members"></textarea>
                    <button type="submit" name="add-members">Tambah Anggota</button>
                </form>
            </div>
        </div>
            <div class="read">
                <div class="read-about">
                    <?php foreach ($about as $abt): ?>
                        <div class="about-item">
                            <ol>
                                <li><strong>Deskripsi:</strong>
                                    <p><?= $abt["desk_about"]; ?></p>
                                </li>
                                <li><strong>Visi:</strong>
                                    <p><?= $abt["visi"]; ?></p>
                                </li>
                                <li><strong>Deskripsi Bagian Kontak:</strong>
                                    <p><?= $abt["shortdesk_contact"]; ?></p>
                                </li>
                                <li><strong>Email Kontak:</strong>
                                    <p><?= $abt["email_contact"]; ?></p>
                                </li>
                                <li><strong>Kontak No Telepon:</strong>
                                    <p><?= $abt["tlp_contact"]; ?></p>
                                </li>
                                <li><strong>Alamat:</strong>
                                    <p><?= $abt["alamat_contact"]; ?></p>
                                </li>
                            </ol>
                            <div class="about-actions">
                                <a href="edit_about.php?id_about=<?= $abt["id_about"]; ?>" class="btn btn-edit">Edit</a>
                                <a href="?id_about=<?= $abt["id_about"]; ?>" class="btn btn-delete">Hapus</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="read-about">
                    <?php foreach( $misi as $ms): ?>
                    <div class="about-item">
                        <ol>
                            <li><strong>Subjek Misi:</strong>
                                <p><?= $ms["subjek_misi"]; ?>.</p>
                            </li>
                            <li><strong>Deskripsi Misi:</strong>
                                <p><?= $ms["desk_misi"]; ?></p>
                            </li>
                        </ol>
                        <div class="about-actions">
                            <a href="?id_misi=<?= $ms["id_misi"]; ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="read-about">
                    <?php foreach ($members as $member): ?>
                    <div class="about-item">
                        <ol>
                            <img src="../<?= $member["foto_profil"] ?> " width="300px" alt="foto_profil">
                            <li><strong>Nama Anggota:</strong>
                                <p><?= $member["nama_members"] ?></p>
                            </li>
                            <li><strong>Posisi:</strong>
                                <p><?= $member["posisi"] ?></p>
                            </li>
                            <li><strong>Deskripsi Anggota:</strong>
                                <p><?= $member["desk_members"] ?></p>
                            </li>
                        </ol>
                        <div class="about-actions">
                            <a href="?id_members=<?= $member["id_members"]; ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            </div>
    <footer>
        <div class="container-bottom">
            <p>&copy; 2024 KarangKita. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>