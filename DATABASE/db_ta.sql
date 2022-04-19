-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Apr 2022 pada 11.32
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ta`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_absen`
--

CREATE TABLE `tb_absen` (
  `id_absen` int(11) NOT NULL,
  `id_sub_kursus` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `absen` int(11) NOT NULL DEFAULT 0,
  `waktu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_anggota`
--

CREATE TABLE `tb_anggota` (
  `id_anggota` int(11) NOT NULL,
  `id_kursus` int(11) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_chating`
--

CREATE TABLE `tb_chating` (
  `id_chating` int(11) NOT NULL,
  `id_pengirim` int(11) NOT NULL,
  `id_penerima` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_guru`
--

CREATE TABLE `tb_guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(125) DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `email` varchar(125) DEFAULT NULL,
  `password` varchar(125) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `role` int(1) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jawaban`
--

CREATE TABLE `tb_jawaban` (
  `id_jawaban` int(11) NOT NULL,
  `id_kuis` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `id_sub_kursus` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `jawaban` longtext NOT NULL,
  `jwb_file` varchar(100) NOT NULL,
  `nilai` varchar(100) NOT NULL DEFAULT 'Belum dinilai',
  `dikirim` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` int(11) NOT NULL,
  `kelas` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `kelas`) VALUES
(0, 'Belum dilengkapi'),
(11, 'Kelas 1A'),
(12, 'Kelas 1B'),
(13, 'Kelas 2A'),
(14, 'Kelas 2B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kritik`
--

CREATE TABLE `tb_kritik` (
  `id_kritik` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `kritik` text DEFAULT NULL,
  `saran` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kuis`
--

CREATE TABLE `tb_kuis` (
  `id_kuis` int(11) NOT NULL,
  `id_kursus` int(11) DEFAULT NULL,
  `id_sub_kursus` int(11) DEFAULT NULL,
  `nama_kuis` varchar(125) DEFAULT NULL,
  `pertemuan` int(11) DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `url` varchar(20) DEFAULT NULL,
  `kuis` text DEFAULT NULL,
  `dibuat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kursus`
--

CREATE TABLE `tb_kursus` (
  `id_kursus` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `gambar` varchar(125) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_mapel`
--

CREATE TABLE `tb_mapel` (
  `id_mapel` int(11) NOT NULL,
  `mapel` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_materi`
--

CREATE TABLE `tb_materi` (
  `id_materi` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `id_sub_kursus` int(11) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `nama_file` varchar(125) NOT NULL,
  `url` text DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `dibuat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_setting`
--

CREATE TABLE `tb_setting` (
  `id_setting` int(11) NOT NULL,
  `desk1` text DEFAULT NULL,
  `desk2` text DEFAULT NULL,
  `desk3` text DEFAULT NULL,
  `desk4` text DEFAULT NULL,
  `nama_sekolah` varchar(255) DEFAULT NULL,
  `npsn` varchar(50) DEFAULT NULL,
  `jenjang` varchar(25) DEFAULT NULL,
  `status_sekolah` varchar(20) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `rt` varchar(50) DEFAULT NULL,
  `rw` varchar(50) DEFAULT NULL,
  `kd_pos` int(11) DEFAULT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `kabupaten` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fb` varchar(50) DEFAULT NULL,
  `tlp` varchar(20) DEFAULT NULL,
  `map` text DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_setting`
--

INSERT INTO `tb_setting` (`id_setting`, `desk1`, `desk2`, `desk3`, `desk4`, `nama_sekolah`, `npsn`, `jenjang`, `status_sekolah`, `alamat`, `rt`, `rw`, `kd_pos`, `kelurahan`, `kecamatan`, `kabupaten`, `email`, `fb`, `tlp`, `map`, `foto`, `logo`) VALUES
(1, 'Pembelajaran elektronik atau pembelajaran online yang disebut E-Learning adalah pembelajaran formal maupun non formal yang dilakukan dengan memanfaatkan teknologi, sehingga pelajar dan pengajar melakukan proses belajar mengajar menggunakan media elektronik. E-Learning dilakukan dalam jaringan, siswa dan guru bisa mengaksesnya di mana saja dan kapan saja. Pembelajaran elektronik atau pembelajaran online yang disebut E-Learning adalah pembelajaran formal maupun non formal yang dilakukan dengan memanfaatkan teknologi, sehingga pelajar dan pengajar melakukan proses belajar mengajar menggunakan media elektronik. E-Learning dilakukan dalam jaringan, siswa dan guru bisa mengaksesnya di mana saja dan kapan saja.', 'E-Learning yang sering ada biasanya berbentuk kursus online, seminar online, dan lain sebagainya. Umumnya E-Learning dilakukan melalui perantara internet berbasis web, semua materi, kuis dan bahan ajar bisa diakses pada web tersebut. Materi yang ada bisa berupa teks yang diformat menjadi bentuk file pdf, berbentuk suara, ada juga yang berbentuk streaming YouTube. Perkembangan ini bisa membantu Anda untuk lebih memahami materi yang diajarkan secara lebih detail.', 'Elearning merupakan salah satu cara yang sangat efisien untuk menyampaikan kursus atau pembelajaran secara online. Karena kenyamanan dan fleksibilitasnya, sumber daya tersedia dari mana saja dan kapan saja. Setiap orang, yang merupakan siswa paruh waktu atau bekerja penuh waktu, dapat memanfaatkan pembelajaran berbasis web.', 'Beberapa keunggulan lain yang dimiliki oleh pembelajaran secara online adalah siswa diberi kebebasan untuk mengikuti pembelajaran online dimanapun sesuai kenyamanannya. Selain itu biaya yang dikeluarkan juga terbilang hemat, karena kendala geografis bisa diatasi dengan minimnya kebutuhan ruang kelas dan guru yang mengajar. (sumber - idcloudhost.com/apa-itu-e-learning-pengertian-rekomendasi-contoh-dan-cara-install-nya/)', 'SD Negeri 01 Wiroditan', '20323610', 'SD', 'Negeri', 'Jl. Raya Wiroditan No. 45', '9', '2', 51156, 'Wiroditan', 'Kec. Bojong', 'Kab. Pekalongan', 'example@gmail.com', 'example.fb', '3423422353', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.4389889868453!2d109.60670637516947!3d-6.957430570049165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7021f824a1995d%3A0x1703491ec8e857d2!2sSDN%2001%20WIRODITAN!5e0!3m2!1sid!2sid!4v1647778378734!5m2!1sid!2sid', '20220205.png', '1649691396_fc362b246b01de98b436.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama_siswa` varchar(125) DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `kelas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sub_kursus`
--

CREATE TABLE `tb_sub_kursus` (
  `id_sub_kursus` int(11) NOT NULL,
  `id_kursus` int(11) NOT NULL,
  `sub_kursus` varchar(125) NOT NULL,
  `id_ta` int(11) DEFAULT NULL,
  `tipe` int(1) NOT NULL,
  `mulai` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_ta`
--

CREATE TABLE `tb_ta` (
  `id_ta` int(11) NOT NULL,
  `tahun` varchar(11) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_ta`
--

INSERT INTO `tb_ta` (`id_ta`, `tahun`, `semester`, `status`) VALUES
(1, '2020/2021', '1', 1),
(4, '2020/2021', '2', 0),
(5, '2021/2022', '1', 0),
(6, '2021/2022', '2', 0),
(7, '2022/2023', '1', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(125) DEFAULT NULL,
  `username` varchar(125) DEFAULT NULL,
  `email` varchar(125) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(1) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_user`, `username`, `email`, `password`, `role`, `foto`, `is_active`, `created_at`, `updated_at`) VALUES
(8, 'Humaidi Zakaria', 'admin', 'admin@gmail.com', '$2y$10$Spo9HNeNHARdyQC0E4y3jeznwuvFicCONPQpxz1EWS/7TpJ/Ix/Im', 1, '8.png', 1, '2022-01-31 01:15:05', '2022-03-21 07:57:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_absen`
--
ALTER TABLE `tb_absen`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `id_sub_kursus` (`id_sub_kursus`),
  ADD KEY `id_kursus` (`id_kursus`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `tb_anggota`
--
ALTER TABLE `tb_anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD KEY `id_kursus` (`id_kursus`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `tb_chating`
--
ALTER TABLE `tb_chating`
  ADD PRIMARY KEY (`id_chating`),
  ADD KEY `id_pengirim` (`id_pengirim`),
  ADD KEY `id_penerima` (`id_penerima`);

--
-- Indeks untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `tb_jawaban`
--
ALTER TABLE `tb_jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_kursus` (`id_kursus`),
  ADD KEY `id_sub_kursus` (`id_sub_kursus`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_kuis` (`id_kuis`);

--
-- Indeks untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `tb_kritik`
--
ALTER TABLE `tb_kritik`
  ADD PRIMARY KEY (`id_kritik`);

--
-- Indeks untuk tabel `tb_kuis`
--
ALTER TABLE `tb_kuis`
  ADD PRIMARY KEY (`id_kuis`),
  ADD KEY `id_kursus` (`id_kursus`),
  ADD KEY `id_sub_kursus` (`id_sub_kursus`);

--
-- Indeks untuk tabel `tb_kursus`
--
ALTER TABLE `tb_kursus`
  ADD PRIMARY KEY (`id_kursus`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `tb_mapel`
--
ALTER TABLE `tb_mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `tb_materi`
--
ALTER TABLE `tb_materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `id_kursus` (`id_kursus`),
  ADD KEY `id_sub_kursus` (`id_sub_kursus`);

--
-- Indeks untuk tabel `tb_setting`
--
ALTER TABLE `tb_setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indeks untuk tabel `tb_sub_kursus`
--
ALTER TABLE `tb_sub_kursus`
  ADD PRIMARY KEY (`id_sub_kursus`),
  ADD KEY `id_kursus` (`id_kursus`),
  ADD KEY `id_ta` (`id_ta`);

--
-- Indeks untuk tabel `tb_ta`
--
ALTER TABLE `tb_ta`
  ADD PRIMARY KEY (`id_ta`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_absen`
--
ALTER TABLE `tb_absen`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_anggota`
--
ALTER TABLE `tb_anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=494;

--
-- AUTO_INCREMENT untuk tabel `tb_chating`
--
ALTER TABLE `tb_chating`
  MODIFY `id_chating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT untuk tabel `tb_jawaban`
--
ALTER TABLE `tb_jawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `tb_kritik`
--
ALTER TABLE `tb_kritik`
  MODIFY `id_kritik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_kuis`
--
ALTER TABLE `tb_kuis`
  MODIFY `id_kuis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `tb_kursus`
--
ALTER TABLE `tb_kursus`
  MODIFY `id_kursus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tb_mapel`
--
ALTER TABLE `tb_mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `tb_materi`
--
ALTER TABLE `tb_materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT untuk tabel `tb_sub_kursus`
--
ALTER TABLE `tb_sub_kursus`
  MODIFY `id_sub_kursus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `tb_ta`
--
ALTER TABLE `tb_ta`
  MODIFY `id_ta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_absen`
--
ALTER TABLE `tb_absen`
  ADD CONSTRAINT `tb_absen_ibfk_1` FOREIGN KEY (`id_sub_kursus`) REFERENCES `tb_sub_kursus` (`id_sub_kursus`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_absen_ibfk_2` FOREIGN KEY (`id_kursus`) REFERENCES `tb_kursus` (`id_kursus`),
  ADD CONSTRAINT `tb_absen_ibfk_3` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_absen_ibfk_4` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`);

--
-- Ketidakleluasaan untuk tabel `tb_anggota`
--
ALTER TABLE `tb_anggota`
  ADD CONSTRAINT `tb_anggota_ibfk_1` FOREIGN KEY (`id_kursus`) REFERENCES `tb_kursus` (`id_kursus`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_anggota_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_chating`
--
ALTER TABLE `tb_chating`
  ADD CONSTRAINT `tb_chating_ibfk_1` FOREIGN KEY (`id_pengirim`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_jawaban`
--
ALTER TABLE `tb_jawaban`
  ADD CONSTRAINT `tb_jawaban_ibfk_1` FOREIGN KEY (`id_kuis`) REFERENCES `tb_kuis` (`id_kuis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_jawaban_ibfk_2` FOREIGN KEY (`id_kursus`) REFERENCES `tb_kursus` (`id_kursus`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tb_jawaban_ibfk_3` FOREIGN KEY (`id_sub_kursus`) REFERENCES `tb_sub_kursus` (`id_sub_kursus`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tb_jawaban_ibfk_4` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_kuis`
--
ALTER TABLE `tb_kuis`
  ADD CONSTRAINT `tb_kuis_ibfk_1` FOREIGN KEY (`id_kursus`) REFERENCES `tb_kursus` (`id_kursus`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_kuis_ibfk_2` FOREIGN KEY (`id_sub_kursus`) REFERENCES `tb_sub_kursus` (`id_sub_kursus`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_kursus`
--
ALTER TABLE `tb_kursus`
  ADD CONSTRAINT `tb_kursus_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `tb_mapel` (`id_mapel`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_kursus_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_kursus_ibfk_3` FOREIGN KEY (`id_guru`) REFERENCES `tb_guru` (`id_guru`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_materi`
--
ALTER TABLE `tb_materi`
  ADD CONSTRAINT `tb_materi_ibfk_1` FOREIGN KEY (`id_kursus`) REFERENCES `tb_kursus` (`id_kursus`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_materi_ibfk_2` FOREIGN KEY (`id_sub_kursus`) REFERENCES `tb_sub_kursus` (`id_sub_kursus`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `tb_siswa_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `tb_kelas` (`id_kelas`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_sub_kursus`
--
ALTER TABLE `tb_sub_kursus`
  ADD CONSTRAINT `tb_sub_kursus_ibfk_1` FOREIGN KEY (`id_kursus`) REFERENCES `tb_kursus` (`id_kursus`),
  ADD CONSTRAINT `tb_sub_kursus_ibfk_2` FOREIGN KEY (`id_ta`) REFERENCES `tb_ta` (`id_ta`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
