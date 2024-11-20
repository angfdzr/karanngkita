<?php
session_start();
require '../user/functions.php';

function edit_about($data){
    global $conn;
    $id_about = $data["id_about"];
    $desk_about = htmlspecialchars($data["desk_about"]);
    $visi = htmlspecialchars($data["visi"]);
    $shortdesk_contact = htmlspecialchars($data["shortdesk_contact"]);
    $email_contact = htmlspecialchars($data["email_contact"]);
    $tlp_contact = htmlspecialchars($data["tlp_contact"]);
    $alamat_contact = htmlspecialchars($data["alamat_contact"]);
    
    $query = "UPDATE about SET
            desk_about = '$desk_about',
            visi = '$visi',
            shortdesk_contact = '$shortdesk_contact',
            email_contact = '$email_contact',
            tlp_contact = '$tlp_contact',
            alamat_contact = '$alamat_contact'
            WHERE id_about = '$id_about'";

    mysqli_query ($conn, $query);
    return mysqli_affected_rows($conn);
}

if (!isset($_GET["id_about"])){
    echo "ID tidak ditemukan.";
    exit;
}

$id_about = $_GET["id_about"];
$about = query("SELECT * FROM about WHERE id_about = $id_about")[0];

if (isset($_POST["edit_about"])){
    if (edit_about($_POST) > 0){
        echo "<script>
                alert('Data Berhasil Diubah');
                document.location.href = 'about.php'
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Diubah');
                document.location.href = 'about.php'
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About</title>
    <link rel="stylesheet" href="../admin_styling/about.css">
</head>
<body>
<div class="kolom-utama">
        <div class="add-menu">
            <h1>Kelola About Us</h1>
            <form action="" method="post">
                <input type="hidden" name="id_about" id="id_about" value="<?= $id_about; ?>">
                <label for="desk_about">Deskripsi:</label>
                <textarea name="desk_about" id="desk_about"><?= $about["desk_about"]; ?></textarea>

                <label for="visi">Visi:</label>
                <textarea name="visi" id="visi"><?= $about["visi"]; ?></textarea>

                <label for="shortdesk_contact">Deskripsi Bagian Kontak:</label>
                <textarea name="shortdesk_contact" id="shortdesk_contact"><?= $about["shortdesk_contact"]; ?></textarea>

                <label for="email_contact">Email Contact:</label>
                <input type="email" name="email_contact" id="email_contact" value="<?= $about["email_contact"]; ?>">

                <label for="tlp_contact">Kontak No Telepon:</label>
                <input type="text" name="tlp_contact" id="tlp_contact" value="<?= $about["tlp_contact"]; ?>">

                <label for="alamat_contact">Alamat:</label>
                <textarea name="alamat_contact" id="alamat_contact"><?= $about["alamat_contact"]; ?></textarea>

                <button type="submit" name="edit_about">Edit</button>
            </form>
        </div>
        </div>
</body>
</html>