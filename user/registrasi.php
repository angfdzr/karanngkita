<?php 
require 'functions.php';

function registrasi( $data ){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string( $conn, $data["password"] );
    $password2 = mysqli_real_escape_string( $conn, $data["password2"] );
    $nama_lengkap = mysqli_real_escape_string($conn, $data["nama_lengkap"]);
    $no_telepon = mysqli_real_escape_string($conn, $data["no_telepon"]);
    $negara = mysqli_real_escape_string($conn, $data["negara"]);
    $gender = mysqli_real_escape_string($conn, $data["gender"]);

    // cek username
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)){
        echo "<script>
            alert ('Username Sudah Ada');
            </script>";
        return false;
    }

    if ($password !== $password2 ){
        echo "<script>
            alert ('Konfirmasi Password Tidak Sesuai');
            </script>";
        return false;
    }

    // enkripsi pass dulu
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // tambahkan user baru ke database
    mysqli_query( $conn,"INSERT INTO user VALUES ('', '$username', '$password', '$nama_lengkap', '$no_telepon', '$negara', '$gender') ");
    return mysqli_affected_rows($conn);

}

if (isset($_POST["register"])){
    if(registrasi($_POST) > 0 ){
        echo "<script>
            alert ('Registrasi Berhasil');
            </script>";
            header("Location: login.php");
            exit;
    } else {
        echo mysqli_error( $conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="../styling/style.css">
</head>
<body>
<div class="container">
<div class="logo"><img src="../img/logo.jpg" alt="Logo"></div>
        <h1 class="login">Halaman Registrasi</h1>
        <div class="form-container">
            <form action="" method="post">
                <ul>
                    <li>
                        <label for="nama_lengkap">Nama Lengkap: </label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" required autocomplete="off">
                    </li>
                    <li>
                        <label for="no_telepon">No Telepon: </label>
                        <input type="number" name="no_telepon" id="no_telepon" required autocomplete="off">
                    </li>
                    <li>
                        <label for="negara">Negara: </label>
                        <input type="text" name="negara" id="negara" required autocomplete="off">
                    </li>
                    <li>
                        <label for="gender">Gender: </label>
                        <select name="gender" id="gender">
                            <option value="gender">Laki-laki</option>
                            <option value="gender">Perempuan</option>
                        </select>
                    </li>
                    <li>
                        <label for="username">Username: </label>
                        <input type="text" name="username" id="username" required autocomplete="off">
                    </li>
                    <li>
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password" required>
                    </li>
                    <li>
                        <label for="password2">Konfirmasi Password: </label>
                        <input type="password" name="password2" id="password2" required>
                    </li>
                    <li><button type="submit" name="register">Registrasi</button></li>
                    <li><a href="login.php">Sudah punya akun? Login di sini</a></li>
                </ul>
            </form>
        </div>
    </div>
    </script>
</body>
</html>