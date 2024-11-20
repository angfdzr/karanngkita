-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Nov 2024 pada 17.12
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `about`
--

CREATE TABLE `about` (
  `id_about` int(11) NOT NULL,
  `desk_about` text NOT NULL,
  `visi` text NOT NULL,
  `shortdesk_contact` text NOT NULL,
  `email_contact` varchar(200) NOT NULL,
  `tlp_contact` varchar(20) NOT NULL,
  `alamat_contact` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `about`
--

INSERT INTO `about` (`id_about`, `desk_about`, `visi`, `shortdesk_contact`, `email_contact`, `tlp_contact`, `alamat_contact`) VALUES
(3, 'KarangKita adalah platform yang bertujuan untuk memantau dan mendeteksi kesehatan terumbu karang di seluruh Indonesia. Kami percaya bahwa terumbu karang adalah fondasi kehidupan laut dan memiliki peran penting dalam ekosistem global. Melalui teknologi terkini, kami berupaya meningkatkan kesadaran dan keterlibatan masyarakat dalam upaya konservasi.\r\n\r\n\r\nDengan dukungan dari komunitas, peneliti, dan pegiat lingkungan, kami menyediakan platform yang memungkinkan deteksi dini masalah kesehatan terumbu karang, seperti bleaching atau kerusakan fisik lainnya. Kami percaya bahwa dengan pengetahuan yang tepat, masyarakat bisa berperan aktif dalam menjaga laut kita.', 'Visi kami adalah menjadi platform terdepan dalam upaya pelestarian ekosistem laut yang berkelanjutan, tidak hanya untuk Indonesia, tetapi juga untuk dunia. Dengan berkolaborasi bersama masyarakat, organisasi lingkungan, dan pemerintah, kami bertekad untuk mewujudkan lautan yang sehat dan berkelanjutan untuk generasi mendatang.', 'Jika Anda memiliki pertanyaan, saran, atau ingin berkolaborasi dalam upaya pelestarian terumbu karang, jangan ragu untuk menghubungi kami:', 'karangkita24@gmail.com', '085945973369', 'Jl. Utan Panjang III No. 2 Rt003/Rw005, Utan Panjang, Kemayoran, 10650');

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `user_admin` varchar(50) DEFAULT NULL,
  `pass_admin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `user_admin`, `pass_admin`) VALUES
(1, 'admin', '$2y$10$aeLfFo1jlw2L1oa3bXLQced4JpmddrVpTMQwEguXYPhv4Rt06nury'),
(2, 'admin angga', '$2y$10$kMr0pEIR0kgeBg1Bb7LzbutYnuHZ4HdkDxBuC7vCAeHuhjbpA7lrK');

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_article`
--

CREATE TABLE `admin_article` (
  `id_adminArticle` int(11) NOT NULL,
  `judulAdmin_article` varchar(200) NOT NULL,
  `penulisAdmin_article` varchar(200) NOT NULL,
  `gambarAdmin_article` varchar(250) NOT NULL,
  `deskAdmin_article` text NOT NULL,
  `createdAdmin_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin_article`
--

INSERT INTO `admin_article` (`id_adminArticle`, `judulAdmin_article`, `penulisAdmin_article`, `gambarAdmin_article`, `deskAdmin_article`, `createdAdmin_at`, `status`) VALUES
(15, 'Kerusakan terumbu karang di Pulo Panjang', 'Husein', 'article/673a16a995e7e.jpeg', '<p>Kerusakan terumbu karang telah terjadi di <i><strong>Pulo Panjang</strong></i>.</p>', '2024-11-17 16:15:37', 'pending'),
(16, 'Kerusakan terumbu karang di Pulo Panjang', 'Husein', 'article/673a187753a6b.jpeg', '<p>Terjadi kerusakan <strong>Terumbu Karang </strong>di Pulo Panjang.</p>', '2024-11-17 16:23:19', 'pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_voluntrip` int(11) DEFAULT NULL,
  `pengomentar` varchar(255) DEFAULT NULL,
  `pesan_komentar` text DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_konservasi` int(11) DEFAULT NULL,
  `id_userArticle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `komentar`
--

INSERT INTO `komentar` (`id_komentar`, `id_voluntrip`, `pengomentar`, `pesan_komentar`, `waktu`, `id_konservasi`, `id_userArticle`) VALUES
(50, NULL, 'Annisa Husein', 'Berita yang baik!', '2024-11-17 16:11:00', NULL, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `konservasi`
--

CREATE TABLE `konservasi` (
  `id_konservasi` int(11) NOT NULL,
  `gambar_konservasi` varchar(50) DEFAULT NULL,
  `nama_konservasi` varchar(200) DEFAULT NULL,
  `lokasi_konservasi` varchar(200) DEFAULT NULL,
  `shortdesk_konservasi` varchar(150) DEFAULT NULL,
  `longdesk_konservasi` text DEFAULT NULL,
  `manfaat_konservasi` text DEFAULT NULL,
  `waktu_konservasi` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `konservasi`
--

INSERT INTO `konservasi` (`id_konservasi`, `gambar_konservasi`, `nama_konservasi`, `lokasi_konservasi`, `shortdesk_konservasi`, `longdesk_konservasi`, `manfaat_konservasi`, `waktu_konservasi`) VALUES
(7, 'images/6739ee71dd612.jpeg', 'Konservasi Alam Bawah Laut Carita', 'Banten', 'Aspek Penting Konservasi Bawah Laut Sukarame\r\nPelestarian Terumbu Karang\r\n\r\nTerumbu karang adalah fondasi kehidupan laut yang mendukung ribuan spesies', '<p><strong>Konservasi Bawah Laut Sukarame</strong> adalah sebuah inisiatif atau program pelestarian lingkungan yang bertujuan untuk menjaga dan memulihkan ekosistem bawah laut di wilayah Sukarame, yang terletak di perairan Indonesia. Daerah ini, seperti banyak wilayah lainnya di Indonesia, dikenal memiliki keanekaragaman hayati laut yang kaya, termasuk terumbu karang, ikan karang, dan ekosistem terkait lainnya.</p><p>&nbsp;</p><p><strong>Aspek Penting Konservasi Bawah Laut Sukarame</strong></p><ol><li><strong>Pelestarian Terumbu Karang</strong><ul><li><strong>Terumbu karang</strong> adalah fondasi kehidupan laut yang mendukung ribuan spesies. Di Sukarame, inisiatif konservasi sering kali melibatkan transplantasi karang, di mana fragmen karang yang sehat ditanam kembali di area yang rusak untuk membantu regenerasi.</li><li>Terumbu karang di daerah ini menghadapi ancaman dari aktivitas manusia, seperti penangkapan ikan destruktif, sedimentasi akibat pembangunan pesisir, dan perubahan iklim yang menyebabkan pemutihan karang (<i>coral bleaching</i>).</li></ul></li><li><strong>Pengelolaan Keanekaragaman Hayati</strong><ul><li>Wilayah Sukarame mendukung populasi ikan yang menjadi sumber penghidupan bagi masyarakat lokal. Dengan pengelolaan yang baik, seperti penetapan zona larangan tangkap (<i>no-take zone</i>), ekosistem bawah laut dapat tetap produktif dan berkelanjutan.</li></ul></li><li><strong>Edukasi dan Kesadaran Masyarakat</strong><ul><li>Salah satu komponen penting dari konservasi di Sukarame adalah melibatkan masyarakat lokal dan pengunjung dalam upaya perlindungan. Program edukasi biasanya menyoroti pentingnya menjaga lingkungan bawah laut untuk mendukung mata pencaharian mereka, seperti pariwisata dan perikanan.</li></ul></li><li><strong>Dukungan Pariwisata Berkelanjutan</strong><ul><li>Konservasi di Sukarame sering kali diintegrasikan dengan pariwisata berbasis ekologi. Wisatawan dapat menikmati keindahan bawah laut melalui kegiatan seperti snorkeling dan menyelam, tetapi dengan aturan yang ketat untuk meminimalkan dampak terhadap lingkungan.</li></ul></li><li><strong>Kerja Sama dengan Organisasi Lingkungan</strong><ul><li>Upaya konservasi sering kali melibatkan kerja sama antara pemerintah daerah, organisasi non-pemerintah, dan institusi akademik. Penelitian tentang kesehatan ekosistem bawah laut, seperti survei terumbu karang dan monitoring kualitas air, juga merupakan bagian dari konservasi Sukarame.</li></ul></li></ol><p><strong>Tantangan Konservasi</strong></p><ul><li><strong>Polusi Laut:</strong> Limbah domestik dan plastik yang masuk ke laut bisa membahayakan ekosistem bawah laut.</li><li><strong>Overfishing:</strong> Penangkapan ikan secara berlebihan mengancam keseimbangan ekosistem.</li><li><strong>Perubahan Iklim:</strong> Pemanasan global dan kenaikan suhu laut dapat mempercepat degradasi terumbu karang.</li></ul><p><strong>Manfaat Konservasi Sukarame</strong></p><ol><li><strong>Keberlanjutan Ekosistem Laut:</strong> Terjaganya habitat laut untuk generasi mendatang.</li><li><strong>Peningkatan Ekonomi Lokal:</strong> Ekowisata dan hasil laut yang berkelanjutan memberikan dampak ekonomi positif bagi masyarakat setempat.</li><li><strong>Mitigasi Bencana:</strong> Terumbu karang berfungsi sebagai penghalang alami terhadap gelombang besar dan erosi pantai.</li></ol>', 'Sukarame', '2024-11-17 13:24:01'),
(8, 'images/6739f0ea942ae.jpg', 'Belajar Bersama Konservasi Terumbu Karang', 'Kota Makassar', 'Halo sobat Environmentalism.\r\n\r\nTak sedikit kegiatan rehabilitasi mangrove yang berakhir gagal karena metode yang digunakan tidak tepat. Menyambut har', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">Halo sobat Environmentalism.</span><br><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">Tak sedikit kegiatan rehabilitasi <strong>terumbu karang</strong> yang berakhir gagal karena metode yang digunakan tidak tepat. Menyambut hari mangrove sedunia 2024, YKL Indonesia bersama dengan Yayasan KEHATI akan mengadakan Pelatihan Fasilitator Rehabilitasi dan <strong>Konservasi Terumbu Karang</strong> di tingkat tapak. Pelatihan ini bertujuan melahirkan fasilitator rehabilitasi dan konservasi yang memahami teori, teknis dan kebijakan serta mampu menyusun rencana aksi.</span><br><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">Jika tertarik, langsung daftar di bit.ly/fasilitatormangrove. Kalian punya teman yang cocok untuk ikut kegiatan ini, silahkan tandai di kolom komentar. Jangan lupa baca dengan seksama informasi dan persyaratannya sebelum mendaftar.</span></p>', 'Yayasan Konservasi Laut (YKL) Indonesia', '2024-11-17 13:34:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `members`
--

CREATE TABLE `members` (
  `id_members` int(11) NOT NULL,
  `foto_profil` varchar(255) NOT NULL,
  `nama_members` varchar(50) NOT NULL,
  `posisi` varchar(130) NOT NULL,
  `desk_members` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `members`
--

INSERT INTO `members` (`id_members`, `foto_profil`, `nama_members`, `posisi`, `desk_members`) VALUES
(3, 'images/672faafadb15d.jpg', 'Angga Fadzar', 'Mahasiswa Sistem Informasi Kelautan', 'Seorang laki-laki dengan rasa penasaran yang tinggi.'),
(4, 'images/6730da34646c8.jpg', 'Nur Annisa Vian Husaine', 'Mahasiswa Sistem Informasi Kelautan', 'Setiap usaha kecil dalam mencapai SDGs adalah kontribusi besar untuk Indonesia Emas yang kita impikan di 2045.'),
(6, 'images/6730dc667a4e2.jpg', 'Annisa Nur Fadillah', 'Mahasiswa Sistem Informasi Kelautan', 'Seorang perempuan yang ingin memiliki ketertarikan pada dunia kelautan.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `misi`
--

CREATE TABLE `misi` (
  `id_misi` int(11) NOT NULL,
  `subjek_misi` varchar(20) NOT NULL,
  `desk_misi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `misi`
--

INSERT INTO `misi` (`id_misi`, `subjek_misi`, `desk_misi`) VALUES
(3, 'Melindungi', 'Meningkatkan kesadaran publik terhadap pentingnya ekosistem terumbu karang dan dampaknya pada keseimbangan ekosistem laut secara keseluruhan.'),
(4, 'Memberdayakan', 'Menyediakan informasi berbasis sains yang akurat agar masyarakat dapat ikut serta dalam upaya pelestarian dan pemantauan ekosistem laut.'),
(5, 'Menyelamatkan', 'Mengembangkan dan memanfaatkan teknologi untuk mendeteksi dan mencegah kerusakan terumbu karang sebelum terjadi kerusakan lebih lanjut.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `saran`
--

CREATE TABLE `saran` (
  `id_saran` int(11) NOT NULL,
  `subjek` varchar(100) NOT NULL,
  `pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `saran`
--

INSERT INTO `saran` (`id_saran`, `subjek`, `pesan`) VALUES
(5, 'annisahusaine', 'aku suka aplikasinya, semoga juara 1 aamiin'),
(6, 'Angga Fadzar', 'Semoga projek ASIK tahun ini dapat menghasilkan hasil yang memuaskan dengan peringkat yang paling terbaik!');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(50) DEFAULT NULL,
  `no_telepon` bigint(20) DEFAULT NULL,
  `negara` varchar(100) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama_lengkap`, `no_telepon`, `negara`, `gender`) VALUES
(33, 'tess', '$2y$10$Fa3CDD6MhbyWY5iUuT5DH.mz45t3zmaM5qBC/2kI5mBON05XK0fza', 'Prihati', 2147483647, 'Indonesia', 'laki laki'),
(34, 'apa', '$2y$10$cC8uyMOxibOJqRlUQfPcs.AOtBTssSydSdAp4bggMQaB1rRwyT7QK', 'Prihati', 2147483647, 'Indonesia', 'gender'),
(36, 'ang', '$2y$10$qJbPXJJzGNYSOrpZRmdah.aJZYYVhPymvV1Rf0ujeONAAl3w.ozS6', 'Angga', 2147483647, 'Indonesia', 'gender'),
(37, 'angfdzr21', '$2y$10$MMgXkV2Z1gm2GWR14pCFVOLcHjpEG6ngXclDNscOlq51KoAPvb87a', 'Prihati', 81574743603, 'Indonesia', 'gender'),
(38, 'angga fadzar', '$2y$10$n2vmV5siNKTHHKC57nKrOel6bcxYG.SHFonQ5AlGVi0uh5bPmyO0C', 'Angga Fadzar', 81574743603, 'Indonesia', 'Laki-laki'),
(39, 'annisahusaine', '$2y$10$U542lu9m3IAXYCSQch5pcu7J/IJ70y16jDQFaqEDzHW3h9beThHfa', 'Nur Annisa Vian Husaine', 81345944543, 'Indonesia', 'gender');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_article`
--

CREATE TABLE `user_article` (
  `id_userArticle` int(11) NOT NULL,
  `judul_article` varchar(200) NOT NULL,
  `penulis_article` varchar(200) NOT NULL,
  `gambar_article` varchar(250) NOT NULL,
  `desk_article` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_article`
--

INSERT INTO `user_article` (`id_userArticle`, `judul_article`, `penulis_article`, `gambar_article`, `desk_article`, `created_at`) VALUES
(12, 'Kerusakan Terumbu Karang di Pulau Panjang, Indonesia', 'Admin', 'article/6739e16dadc56.jpg', '<p style=\"text-align:justify;\">Terumbu karang di Pulau Panjang, Kabupaten Jepara, mengalami kerusakan yang signifikan. Berdasarkan hasil pengamatan, ditemukan bahwa sekitar 60% terumbu karang menunjukkan gejala pemutihan (coral bleaching) akibat peningkatan suhu laut yang mencapai 30°C. Kerusakan fisik juga terlihat di beberapa area, terutama pada bagian barat terumbu, yang disebabkan oleh aktivitas kapal, seperti jangkar yang merusak struktur karang. &nbsp;</p><p style=\"text-align:justify;\">&nbsp;</p><p style=\"text-align:justify;\">Selain itu, pencemaran limbah plastik dan jaring ikan yang tersangkut di karang turut memperburuk kondisi ekosistem ini. Area yang terdampak kerusakan diperkirakan mencapai 1,5 hektar dengan tingkat kerusakan parah hingga sedang. Spesies karang seperti <i>Acropora spp.</i> dan <i>Montipora spp.</i> mengalami penurunan kualitas habitat, yang juga berdampak pada pengurangan populasi ikan karang hingga 25%. &nbsp;</p><p style=\"text-align:justify;\">&nbsp;</p><p style=\"text-align:justify;\">Kerusakan ini diperkirakan disebabkan oleh kombinasi faktor manusia, seperti pembuangan sampah oleh wisatawan dan penggunaan jangkar, serta faktor lingkungan, seperti pemanasan suhu laut dan kondisi gelombang tinggi. Akibatnya, terjadi penurunan kualitas ekosistem terumbu karang yang berimbas pada sektor pariwisata bahari dan penghidupan masyarakat pesisir yang bergantung pada hasil laut. &nbsp;</p><p style=\"text-align:justify;\">&nbsp;</p><p style=\"text-align:justify;\">Untuk mengatasi kerusakan ini, direkomendasikan beberapa tindakan, antara lain penanaman kembali terumbu karang, edukasi kepada masyarakat dan wisatawan, serta peningkatan pengawasan lingkungan. Upaya ini diharapkan dapat memperbaiki kondisi ekosistem terumbu karang dan menjaga keberlanjutannya.</p>', '2024-11-17 12:28:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `voluntrip`
--

CREATE TABLE `voluntrip` (
  `id_voluntrip` int(11) NOT NULL,
  `gambar_voluntrip` varchar(50) DEFAULT NULL,
  `nama_voluntrip` varchar(200) DEFAULT NULL,
  `rekomen_voluntrip` varchar(200) DEFAULT NULL,
  `shortdesk_voluntrip` varchar(150) DEFAULT NULL,
  `longdesk_voluntrip` text DEFAULT NULL,
  `owner_voluntrip` varchar(30) DEFAULT NULL,
  `dibuat_voluntrip` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `voluntrip`
--

INSERT INTO `voluntrip` (`id_voluntrip`, `gambar_voluntrip`, `nama_voluntrip`, `rekomen_voluntrip`, `shortdesk_voluntrip`, `longdesk_voluntrip`, `owner_voluntrip`, `dibuat_voluntrip`) VALUES
(21, 'images/6739f17003987.jpeg', 'Coastal Conservation Journey', 'Batuhiu Pangandaran', 'Coastal Conservation Journey merupakan kegiatan volunteer yang diselenggarakan oleh Himpunan Mahasiswa Perikanan Universitas Padjajaran yang memiliki ', '<p style=\"text-align:justify;\"><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">Halo Akang Teteh!👋🏻</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">Himikan UNPAD mengajak kalian berpartisipasi dalam kegiatan <i><strong>Coastal Conservation Journey</strong></i>🤩</span><br><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">Pelaksaan <i><strong>Coastal Conservation Journey</strong></i> akan dilaksanakan pada :</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">📅 Hari/Tanggal : Sabtu, 23 November 2024</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">📍Lokasi : Batu Hiu, Pangandaran</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">💰Biaya Pendaftaran : Rp.125.000,-</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">💰Bundling Pendaftaran : Rp.360.000,-/3 Orang</span><br><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">📝Kegiatan yang akan dilakukan diantaranya:</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">- Penanaman pandan laut untuk mencegah abrasi</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">- Pelestarian tukik agar populasi penyu tetap terjaga</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">- Aksi bersih-bersih pantai untuk mengurangi sampah laut</span><br><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">📱Pendaftaran mulai dari tanggal 7 - 16 November 2024 bisa melalui link dibawah:</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">https://bit.ly/PendaftaranVolunteerCCJ</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">https://bit.ly/PendaftaranVolunteerCCJ</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">https://bit.ly/PendaftaranVolunteerCCJ</span><br><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">💳Pembayaran bisa melalui nomor rekening atau e-wallet :</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">Bank Mandiri : 1320026272519 a.n Bella Mutia</span><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">DANA : 081319645615 a.n Dinar Restu Febrian</span><br><br><span style=\"background-color:rgb(255,255,255);color:rgb(0,0,0);\">Yuk, kita selamatkan ekosistem&nbsp;laut&nbsp;bersama‼</span></p>', 'Himpunan Mahasiswa Perikanan', '2024-11-17 12:21:43'),
(22, 'images/6739f2b632f3b.jpeg', 'Voluntrip Terumbu Karang: Liburan Sambil Berkontribusi untuk Alam', 'Lampung', 'Di era modern ini, konsep pariwisata tidak lagi hanya soal menikmati keindahan alam, tetapi juga berkontribusi untuk melestarikannya. Salah satu kegia', '<p>Di era modern ini, konsep pariwisata tidak lagi hanya soal menikmati keindahan alam, tetapi juga berkontribusi untuk melestarikannya. Salah satu kegiatan yang memadukan keduanya adalah <strong>voluntrip terumbu karang</strong>. Voluntrip ini memberikan kesempatan bagi para pecinta alam untuk menjelajahi keindahan bawah laut sembari ikut berperan aktif dalam upaya konservasi.</p><p><strong>Apa itu Voluntrip Terumbu Karang?</strong></p><p>Voluntrip terumbu karang adalah bentuk pariwisata sukarela, di mana peserta tidak hanya menjadi wisatawan, tetapi juga menjadi relawan konservasi. Dalam kegiatan ini, peserta diajak untuk menjaga dan memulihkan ekosistem terumbu karang, yang menjadi habitat penting bagi ribuan spesies laut. Indonesia, sebagai negara dengan kekayaan terumbu karang terbesar di dunia, menawarkan berbagai destinasi untuk menjalankan aktivitas ini.</p><p><strong>Aktivitas Seru dalam Voluntrip</strong></p><ol><li><strong>Transplantasi Terumbu Karang</strong><br>Kegiatan utama dalam voluntrip adalah transplantasi karang. Peserta akan diajarkan cara mengambil fragmen karang yang masih sehat dan menanamnya kembali di area terumbu yang rusak. Proses ini dilakukan di bawah bimbingan para ahli kelautan.</li><li><strong>Pembersihan Sampah Laut</strong><br>Sampah, terutama plastik, menjadi ancaman serius bagi ekosistem laut. Dalam kegiatan voluntrip, peserta dapat membantu membersihkan sampah di pantai dan bahkan menyelam untuk membersihkan dasar laut.</li><li><strong>Pengenalan Biota Laut</strong><br>Para peserta akan diperkenalkan pada berbagai spesies yang hidup di ekosistem terumbu karang. Aktivitas ini tidak hanya menyenangkan tetapi juga mendidik, karena memberikan wawasan tentang pentingnya keanekaragaman hayati bawah laut.</li><li><strong>Monitoring Terumbu Karang</strong><br>Peserta membantu mencatat kondisi terumbu karang dan populasi biota laut. Data ini nantinya akan digunakan oleh organisasi konservasi untuk mengukur keberhasilan program pemulihan.</li><li><strong>Kegiatan Budaya Lokal</strong><br>Selain kegiatan konservasi, peserta juga diajak untuk mengenal budaya lokal, seperti memasak makanan tradisional, belajar tarian khas daerah, atau menjelajahi kehidupan masyarakat pesisir.</li></ol><p><strong>Destinasi Voluntrip Terumbu Karang di Indonesia</strong></p><p>Indonesia memiliki banyak destinasi voluntrip yang menakjubkan:</p><ul><li><strong>Bunaken, Sulawesi Utara</strong>: Taman Laut Bunaken adalah salah satu destinasi terbaik untuk menyelam dan berpartisipasi dalam konservasi terumbu karang.</li><li><strong>Karimunjawa, Jawa Tengah</strong>: Pulau-pulau di Karimunjawa menawarkan pengalaman voluntrip yang tak terlupakan, lengkap dengan pemandangan pantai yang indah.</li><li><strong>Pulau Seribu, Jakarta</strong>: Destinasi ini cocok untuk pemula yang ingin mencoba kegiatan voluntrip tanpa harus bepergian jauh.</li><li><strong>Wakatobi, Sulawesi Tenggara</strong>: Surga bawah laut ini menawarkan keanekaragaman hayati laut yang luar biasa dan kesempatan untuk bergabung dalam program pelestarian.</li></ul><p><strong>Mengapa Voluntrip Terumbu Karang Penting?</strong></p><p>Terumbu karang adalah salah satu ekosistem paling penting di dunia. Mereka menyediakan habitat bagi 25% spesies laut, melindungi pantai dari erosi, dan menjadi sumber penghidupan bagi jutaan orang. Sayangnya, aktivitas manusia, seperti overfishing, polusi, dan perubahan iklim, telah menyebabkan kerusakan serius pada terumbu karang.</p><p>Dengan berpartisipasi dalam voluntrip, Anda dapat:</p><ul><li>Membantu memulihkan terumbu karang yang rusak.</li><li>Meningkatkan kesadaran akan pentingnya menjaga lingkungan laut.</li><li>Memberikan dampak positif langsung terhadap komunitas lokal melalui pariwisata berkelanjutan.</li></ul><p><strong>Bagaimana Cara Bergabung dalam Voluntrip?</strong></p><p>Untuk mengikuti voluntrip, Anda bisa bergabung dengan organisasi konservasi yang memiliki program serupa. Beberapa langkah untuk memulai:</p><ol><li>Pilih destinasi yang Anda minati.</li><li>Cari tahu organisasi yang menawarkan program voluntrip di lokasi tersebut.</li><li>Siapkan fisik dan mental, terutama jika kegiatan melibatkan snorkeling atau menyelam.</li><li>Pastikan Anda menggunakan perlengkapan ramah lingkungan, seperti sunscreen bebas bahan kimia berbahaya.</li></ol><p><strong>Kesimpulan</strong></p><p>Voluntrip terumbu karang adalah cara sempurna untuk menggabungkan liburan dengan kontribusi nyata bagi lingkungan. Kegiatan ini tidak hanya memberikan pengalaman tak terlupakan tetapi juga membuka mata kita tentang pentingnya menjaga ekosistem laut. Dengan bergabung dalam voluntrip, Anda turut menjadi bagian dari solusi untuk masa depan laut yang lebih sehat dan lestari.</p><p>Ayo, jadikan liburan Anda lebih bermakna dengan bergabung dalam voluntrip terumbu karang! 🌊</p>', 'Angga Cooperation', '2024-11-17 13:41:40');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id_about`);

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `admin_article`
--
ALTER TABLE `admin_article`
  ADD PRIMARY KEY (`id_adminArticle`);

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `fk_komentar_konservasi` (`id_konservasi`),
  ADD KEY `fk_voluntrip` (`id_voluntrip`),
  ADD KEY `fk_komentar_article` (`id_userArticle`);

--
-- Indeks untuk tabel `konservasi`
--
ALTER TABLE `konservasi`
  ADD PRIMARY KEY (`id_konservasi`);

--
-- Indeks untuk tabel `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id_members`);

--
-- Indeks untuk tabel `misi`
--
ALTER TABLE `misi`
  ADD PRIMARY KEY (`id_misi`);

--
-- Indeks untuk tabel `saran`
--
ALTER TABLE `saran`
  ADD PRIMARY KEY (`id_saran`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_article`
--
ALTER TABLE `user_article`
  ADD PRIMARY KEY (`id_userArticle`);

--
-- Indeks untuk tabel `voluntrip`
--
ALTER TABLE `voluntrip`
  ADD PRIMARY KEY (`id_voluntrip`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `about`
--
ALTER TABLE `about`
  MODIFY `id_about` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `admin_article`
--
ALTER TABLE `admin_article`
  MODIFY `id_adminArticle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `konservasi`
--
ALTER TABLE `konservasi`
  MODIFY `id_konservasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `members`
--
ALTER TABLE `members`
  MODIFY `id_members` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `misi`
--
ALTER TABLE `misi`
  MODIFY `id_misi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `saran`
--
ALTER TABLE `saran`
  MODIFY `id_saran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `user_article`
--
ALTER TABLE `user_article`
  MODIFY `id_userArticle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `voluntrip`
--
ALTER TABLE `voluntrip`
  MODIFY `id_voluntrip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `fk_komentar_article` FOREIGN KEY (`id_userArticle`) REFERENCES `user_article` (`id_userArticle`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_komentar_konservasi` FOREIGN KEY (`id_konservasi`) REFERENCES `konservasi` (`id_konservasi`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_voluntrip` FOREIGN KEY (`id_voluntrip`) REFERENCES `voluntrip` (`id_voluntrip`) ON DELETE SET NULL,
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`id_voluntrip`) REFERENCES `voluntrip` (`id_voluntrip`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
