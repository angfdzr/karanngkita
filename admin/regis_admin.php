<?php
require '../user/functions.php';
function register_admin($data){
    global $conn;

    $user_admin = strtolower(stripslashes($data["user_admin"]));
    $pass_admin = mysqli_real_escape_string($conn,$data["pass_admin"]);

    // cek username
    $result = mysqli_query($conn, "SELECT user_admin FROM admin WHERE user_admin = '$user_admin'");
    if (mysqli_fetch_assoc($result)){
        echo "<script>
            alert ('Username Sudah Ada');
            </script>";
        return false;
    }

    // enkripsi pass dulu
    $pass_admin = password_hash($pass_admin, PASSWORD_DEFAULT);
    
    // tambahkan user baru ke database
    mysqli_query( $conn,"INSERT INTO admin VALUES ('', '$user_admin', '$pass_admin') ");
    return mysqli_affected_rows($conn);

}

if (isset($_POST["register_admin"])){
    if(register_admin($_POST) > 0 ){
        echo "<script>
            alert ('Registrasi Berhasil');
            </script>";
            header("Location: login_admin.php");
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
    <title>Registrasi-Admin</title>
    <link rel="stylesheet" href="../admin_styling/style.css">
</head>
<body>
    <div class="kolom-utama">
        <h1>Tambah Akun</h1>
        <form action="" method="post">
            <label for="user_admin">Username Admin:</label>
            <input type="text" name="user_admin" id="user_admin" autocomplete="off">
            <label for="pass_admin">Password Admin:</label>
            <input type="password" name="pass_admin" id="pass_admin" autocomplete="off">
            <button type="submit" name="register_admin">Tambah Admin</button>
            <a href="login_admin.php">Kembali</a>
        </form>
    </div>
</body>
</html>