
<nav class="menu-utama">
        <div class="container">
            <div class="logo">
                <img src="../img/logo.jpg" alt="logo" width="200px">
            </div>
            <ul>
                <li><a href="dashboard_admin.php">Home</a></li>
                <li>
                    <a href="#">Manage Information</a>
                    <ul class="sub-menu">
                        <li><a href="main_voluntrip.php">Voluntrip</a></li>
                        <li><a href="main_conservation.php">Conservation</a></li>
                        <li><a href="main_report.php">Coral's Report</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Manage Activites</a>
                    <ul class="sub-menu">
                        <li><a href="komentar.php">Commentars</a></li>
                        <li><a href="suggests.php">Suggests</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Manage Views</a>
                    <ul class="sub-menu">
                        <li><a href="about.php">About Us</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><?= $user_admin ?></a>
                    <ul class="sub-menu">
                        <li><a href="logout_admin.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>