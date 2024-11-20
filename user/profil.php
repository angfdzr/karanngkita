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

function edit_profil($data){
    global $conn;
    $id = $data["id"];
    $username = htmlspecialchars($data["username"]);
    $nama_lengkap = htmlspecialchars($data["nama_lengkap"]);
    $no_telepon = htmlspecialchars($data["no_telepon"]);
    $negara = htmlspecialchars($data["negara"]);
    $gender = htmlspecialchars($data["gender"]);

    $query = "UPDATE user SET
                username = '$username',
                nama_lengkap = '$nama_lengkap',
                no_telepon = '$no_telepon',
                negara = '$negara',
                gender = '$gender'
                WHERE id = '$id' ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Ambil data pengguna dari database
$user = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
$user = mysqli_fetch_assoc($user);

// Proses jika tombol edit profil diklik
if (isset($_POST['edit-profil'])) {
    if (edit_profil($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Diubah');
                document.location.href = 'login.php'
            </script>";
    } else {
        echo "<script>
                alert('Data Berhasil Diubah');
                document.location.href = 'login.php'
            </script>";
    }
}

// Proses jika tombol hapus akun diklik
if (isset($_POST['hapus-akun'])) {
    $id = $user['id']; // Ambil ID pengguna yang akan dihapus
    if (hapus($id) > 0) {
        // Hapus session dan arahkan ke halaman login setelah penghapusan
        session_destroy();
        echo "<script>
                alert('Akun Berhasil Dihapus');
                document.location.href = 'login.php';
            </script>";
    } else {
        echo "<script>
                alert('Akun Gagal Dihapus');
                document.location.href = 'profil.php';
            </script>";
    }
}

function hapus($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM user WHERE id = $id");
    return mysqli_affected_rows($conn);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KarangKita - Artikel</title>
    <link rel="stylesheet" href="../styling/profil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="bg-header">
        <h1>Halaman Profil</h1>
    </div>

    <div class="kolom-profil">
        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $user["id"]; ?>">
            <table border="0" cellspacing="0" cellpadding="10">
                <tr>
                    <th>Nama Lengkap:</th>
                    <td>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= $user['nama_lengkap']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <th>No Telepon:</th>
                    <td>
                        <input type="number" name="no_telepon" id="no_telepon" value="<?= $user['no_telepon']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <th>Negara:</th>
                    <td>
                        <input type="text" name="negara" id="negara" value="<?= $user['negara']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <th>Gender:</th>
                    <td>
                        <select name="gender" id="gender">
                            <option value="Laki-laki" <?= $user['gender'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="Perempuan" <?= $user['gender'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Username:</th>
                    <td>
                        <input type="text" name="username" id="username" value="<?= $user['username']; ?>" required>
                    </td>
                </tr>
            </table>
            <button type="submit" name="edit-profil" class="edit-btn-profil">Edit</button>
        </form>
        <form action="" method="post">
            <button type="submit" name="hapus-akun" class="hapus-profil">Hapus Akun</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
