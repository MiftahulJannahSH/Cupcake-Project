-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Apr 2020 pada 08.36
-- Versi server: 10.1.34-MariaDB
-- Versi PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wpu_loginanna`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_project`
--

CREATE TABLE `tb_project` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `keterangan` varchar(128) NOT NULL,
  `link` varchar(128) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_project`
--

INSERT INTO `tb_project` (`id`, `nama`, `keterangan`, `link`, `detail`, `gambar`) VALUES
(27, 'SI Portal Berita SMKN 2 Guguak', 'Berbasis web Menggunakan bahasa pemrograman PHP dan Framework Laravel', 'https://detik.com/', 'Jaringan internet digunakan untuk mendapatkan pangsa pasar yang lebih besar. Portal berita online biasanya berdiri sendiri atau merupakan konvergensi dari media cetak dan elektronik. Contohnya, detik.com dan kapanlagi.com adalah portal berita yang berdiri', 'Screenshot_(75).jpg'),
(28, 'SI Perancangan Program Studi TI', 'Berbasis web Menggunakan bahasa pemrograman PHP Native', 'http://sister.smkn2guguak.sch.id/', 'APA ITU PROGRAM STUDI? Program studi adalah kesatuan rencana belajar sebagai pedoman penyelenggaraan pendidikan akademik dan/atau profesional yang diselenggarakan atas dasar suatu kurikulum serta ditujukan agar mahasiswa dapat menguasai pengetahuan, keter', 'Screenshot_(76).jpg'),
(29, 'SI Profil Sekolah SMKN 2 Guguak', 'Berbasis web Menggunakan bahasa pemrograman PHP dan Framework Laravel', 'https://profilsmkn2guguak.tk/guru', ' Website SMKN 2 Guguak adalah website yang dibangun untuk menunjang transparasi informasi dan promosi sekolah.  Kami Menyambut baik terbitnya Website profile sekolah ini dengan harapan dipublikasinya website ini sekolah berharap : Peningkatan layanan pend', 'Screenshot_(77).png'),
(30, 'SI Project Siswa SMKN 2 Guguak', 'Berbasis web Menggunakan bahasa pemrograman PHP dan Framework Codeigniter', 'http://webcupcake.epizy.com/', 'Cupcake adalah adalah sebuah website yang bergerak dibidang penyimpanan data project, mengelola dan mengembangkannya. Cupcake berdiri pada tanggal 10 November 2019 di Nagari Ampang Gadang, Kec Guguak, Kab Lima Puluh Kota, Sumatera Barat. Seiring dengan pe', 'Screenshot_(49).png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(4, 'Miftahul Jannah SH', 'ana@gmail.com', 'IMG-20190805-WA00054.jpg', '$2y$10$nQBkvd2losj0mo/i.m8sv.HKXAEk6E/PFEvDnBRlX1jtOOfsxYRWa', 1, 1, 1573650919),
(56, 'ana', 'miftahuljannah05012017@gmail.com', 'default.jpg', '$2y$10$hd3kAE7.pBUyhntmfXPp2uXhRRXUWmEbqEN6Mhm2hK3rH6pDNczTS', 2, 1, 1580048945),
(58, 'ana', 'nonamexti4@gmail.com', 'default.jpg', '$2y$10$.chvWioh0V0TPbc21JH3YOJvEM2FSUG2IQvk6JyAhumq7DlxuQdJy', 3, 1, 1580049725),
(62, 'Team Cupcake', 'team.03cupcake@gmail.com', 'default.jpg', '$2y$10$RNWKkU8m.5HdIHmlihT/XuIVcajrpq.jG42Wzdq3xoESYxcimF0h2', 3, 1, 1585899387),
(63, 'Miftaahul Jannah', 'anna.zmhd@gmail.com', 'PER.jpg', '$2y$10$ad5wts1H0HBuFtoLYzrZ6eypR52YqAwXCfkVOnfueAyNxTrTMZc6W', 2, 1, 1585899924);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 2),
(6, 3, 3),
(9, 1, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'Operator'),
(3, 'User'),
(4, 'Menu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Operator'),
(3, 'Member\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dasboard ', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'Dasboard Operator', 'operator', 'fas fa-fw fa-tachometer-alt', 1),
(3, 3, 'Dasboard User', 'user', 'fas fa-fw fa-tachometer-alt', 1),
(4, 1, 'Role ', 'admin/role', 'fas fa-fw fa-map-signs', 1),
(5, 2, 'Input Project', 'operator/input', 'fas fa-fw fa-table', 1),
(6, 4, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(7, 4, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(8, 3, 'My Profile', 'user/profile', 'fas fa-fw fa-user', 1),
(9, 3, 'Change Password', 'user/changepassword', 'fas fa-fw fa-key', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_tim`
--

CREATE TABLE `user_tim` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `keterangan` varchar(128) NOT NULL,
  `gambar` text NOT NULL,
  `whatsapp` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_tim`
--

INSERT INTO `user_tim` (`id`, `nama`, `keterangan`, `gambar`, `whatsapp`) VALUES
(1, 'Rizki Fauzan', 'Ini adalah rizki', 'default.jpg', 'https://api.whatsapp.com/send?phone=6282386934342'),
(2, 'Miftahul Jannah', 'ini adalah anna', '20200412_164910.JPG', 'https://api.whatsapp.com/send?phone=6282286588954'),
(3, 'Hamizan Rafiqi Azuris', 'ini adalah mizan', 'IMG-20200411-WA0005.JPG', 'https://api.whatsapp.com/send?phone=6282285165348');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(50, 'miftahuljannah05012017@gmail.com', 'YFFX9M/zxumbGFha3T2RxKYRlWS6f46P3zX6Vk8jens=', 1580048945),
(52, 'nonamexti4@gmail.com', 'gBHgPW+QJ1qnKgofm4jNLhOH4AYhsD2IVsg/5OkZDA4=', 1580049725),
(53, 'ipi@gmail.com', 'f9W2f1FlaT/wDpJDV+GX1Bmcnr/Krj18mNJg7yLejik=', 1584441591),
(54, 'ipi@gmail.com', 'N4iyxSej4AM6JrZa9serMcipDcJ8cHXjBi65/hq3Qm8=', 1584776284),
(59, 'team.03cupcake@gmail.com', 'odEffNKK8KiDngvr7GNMdNn1UBefGlJ/qDOBiRHlKGg=', 1585899452),
(60, 'team.03cupcake@gmail.com', 'NnxxxMP1DX9EhGs9HrI/bu3SUGw5KfMaI1pSeKXBGak=', 1585899484),
(61, 'anna.zmhd@gmail.com', 'KNqDOAPzmnac2csBCJUyLnU1BIbh/5/rw4k7cEJomlc=', 1586770033);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_project`
--
ALTER TABLE `tb_project`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_tim`
--
ALTER TABLE `user_tim`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_project`
--
ALTER TABLE `tb_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user_tim`
--
ALTER TABLE `user_tim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD CONSTRAINT `user_access_menu_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user_sub_menu` (`id`);

--
-- Ketidakleluasaan untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD CONSTRAINT `user_menu_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user_sub_menu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
