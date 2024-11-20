
<?php 
function saran($data){
    global $conn;
    $subjek = htmlspecialchars($data["subjek"]);
    $pesan = htmlspecialchars($data["pesan"]);

    $query = "INSERT INTO saran (subjek, pesan) VALUES ('$subjek', '$pesan')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

if (isset($_POST['tambah-saran'])){
    if (saran($_POST) > 0 ){
        echo "<script>
            alert('Data Berhasil Ditambahkan');
            document.location.href = 'index.php'
            </script>";
    } else {
            "<script>
            alert('Data Gagal Ditambahkan');
            document.location.href = 'index.php'
            </script>";
    }
}
$about = query("SELECT * FROM about");

?>
<footer >
        <div class="container">
            <!-- Kolom tentang kami -->
            <div class="footer-column">
                <h3>Tentang Kami</h3>
                <?php foreach($about as $abt): ?>
                <p align="justify"><?= $abt["desk_about"] ?></p>
                <?php endforeach; ?>
            </div>

            
            
            <!-- Kolom tautan penting -->
            <div class="footer-column" id="kolom-2">
                <h3>Kirim Pesan</h3>
                <form action="" method="POST">
                    <input type="text" id="subjek" name="subjek" required autocomplete="off" placeholder="Nama Anda">
                    <textarea id="message" name="pesan" rows="8" required placeholder="Isi Pesan Anda"></textarea><br>
                    <?php if (!isset($_SESSION['username'])): ?>
                        <button id="btn-1" type="button" value="Kirim"
                            onclick="alert('Silakan login terlebih dahulu untuk menggunakan fitur ini.');">Kirim</button>
                    <?php else: ?>
                        <button id="btn-2" type="submit" value="Kirim" name="tambah-saran" onclick="alert('Berhasil Mengirim Pesan!');">Kirim</button>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Kolom media sosial -->
            <div class="footer-column" id="kolom-3">
                <h3>Ikuti Kami</h3>
                <div class="social-icons">
                    <a href="#" target="_blank"><i class="fa fa-facebook-square"></i></a>
                    <a href="#" target="_blank"><i class="fa fa-twitter-square"></i></a>
                    <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fa fa-youtube-square"></i></a>
                </div>
                <div class="">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.0370026339483!2d106.14408827498966!3d-6.125722993861027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e418adaa4f7f563%3A0x950ec58123df8596!2sUniversitas%20Pendidikan%20Indonesia%20(UPI)%20Kampus%20Serang!5e0!3m2!1sid!2sid!4v1730965337116!5m2!1sid!2sid"
                        width="300" height="260" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

        <div class="container-bottom">
            <p>&copy; 2024 Coral Health. All rights reserved.</p>
        </div>
    </footer>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        window.onload = function () {
            setTimeout(function () {
                document.querySelector('.hero').classList.add('visible');
            }, 2000); // Tunda 2 detik
        };
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>