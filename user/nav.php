<nav class="menu-utama">
        <div class="container">
            <div class="logo">
                <img src="../img/Karang.png" alt="logo" width="80px">
                <h1 class="karang">Karang</h1>
                <h3>Kita</h3>
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="">Identification</a>
                    <ul class="sub-menu">
                        <li><a href="gambar.php">Take a Picture</a></li>
                        <li><a href="form.php">Fill a Form</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Information</a>
                    <ul class="sub-menu">
                        <li><a href="voluntrip.php">Voluntrip</a></li>
                        <li><a href="conservation.php">Coral's Conservation</a></li>
                        <li><a href="report.php">Coral's Report</a></li>
                    </ul>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li>
                        <a href="#"><?= $username ?></a>
                        <ul class="sub-menu">
                            <li><a href="profil.php">Profil</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    <?php else: ?>
                        <ul class="sub-menu">
                            <li><a href="login.php">Login</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>