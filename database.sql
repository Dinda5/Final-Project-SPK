-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jun 2023 pada 18.06
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_perumahan_saw`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot`
--

CREATE TABLE `bobot` (
  `kd_bobot` int(11) NOT NULL,
  `kd_perumahan` int(11) NOT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `nilai_bobot` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bobot`
--

INSERT INTO `bobot` (`kd_bobot`, `kd_perumahan`, `kd_kriteria`, `nilai_bobot`) VALUES
(1, 1, 1, '0.30'),
(2, 1, 2, '0.30'),
(3, 1, 3, '0.40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_perumahan`
--

CREATE TABLE `daftar_perumahan` (
  `nik` int(9) NOT NULL,
  `nama_perumahan` varchar(30) CHARACTER SET latin1 NOT NULL,
  `alamat` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `tahun` char(4) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `daftar_perumahan`
--

INSERT INTO `daftar_perumahan` (`nik`, `nama_perumahan`, `alamat`, `tahun`) VALUES
(123456789, 'Green Village', 'Condong Catur', '2023'),
(123459876, 'Griya Permata Asri', 'Kota Yogyakarta', '2023'),
(987654321, 'Citra Land', 'Sleman', '2023');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE `hasil` (
  `kd_hasil` int(11) NOT NULL,
  `kd_perumahan` int(11) DEFAULT NULL,
  `ranking` int(11) NOT NULL,
  `nik` int(9) NOT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`kd_hasil`, `kd_perumahan`, `ranking`, `nik`, `nilai`) VALUES
(1, 1, 1, 987654321, 123334);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `kd_kriteria` int(11) NOT NULL,
  `kd_perumahan` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `sifat` enum('min','max') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`kd_kriteria`, `kd_perumahan`, `nama`, `sifat`) VALUES
(1, 1, 'Lokasi', 'max'),
(2, 1, 'Harga', 'min'),
(3, 1, 'Luas', 'max');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `kd_nilai` int(11) NOT NULL,
  `kd_perumahan` int(11) DEFAULT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `nik` int(9) NOT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`kd_nilai`, `kd_perumahan`, `kd_kriteria`, `nik`, `nilai`) VALUES
(1, 1, 1, 123459876, 2),
(2, 1, 2, 123459876, 2),
(3, 1, 3, 123459876, 1),
(4, 1, 1, 987654321, 3),
(5, 1, 2, 987654321, 2),
(6, 1, 3, 987654321, 2),
(7, 1, 1, 123456789, 2),
(8, 1, 2, 123456789, 1),
(9, 1, 3, 123456789, 2),
(10, 1, 1, 123459876, 3),
(11, 1, 2, 123459876, 3),
(12, 1, 3, 123459876, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `kd_pengguna` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `status` enum('petugas','puket','mahasiswa') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`kd_pengguna`, `username`, `password`, `status`) VALUES
(1, 'petugas', 'afb91ef692fd08c445e8cb1bab2ccf9c', 'petugas'),
(2, 'puket', 'b679a71646e932b7c4647a081ee2a148', 'puket');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `kd_penilaian` int(11) NOT NULL,
  `kd_perumahan` int(11) DEFAULT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `bobot` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`kd_penilaian`, `kd_perumahan`, `kd_kriteria`, `keterangan`, `bobot`) VALUES
(1, 1, 1, 'Kulon Progo', 1),
(2, 1, 1, 'Bantul', 2),
(3, 1, 1, 'Sleman', 3),
(4, 1, 1, 'Kota Yogyakarta', 4),
(5, 1, 2, '250jt', 1),
(6, 1, 2, '251jt-500jt', 2),
(7, 1, 2, '510jt-1M', 3),
(8, 1, 2, '>1M', 4),
(9, 1, 3, '<=300', 1),
(10, 1, 3, '400 - 600', 2),
(11, 1, 3, '700 - 1000', 3),
(12, 1, 3, '>= 1100', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `perumahan`
--

CREATE TABLE `perumahan` (
  `kd_perumahan` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `perumahan`
--

INSERT INTO `perumahan` (`kd_perumahan`, `nama`) VALUES
(1, 'Perumahan\r\n');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bobot`
--
ALTER TABLE `bobot`
  ADD PRIMARY KEY (`kd_bobot`),
  ADD KEY `kd_perumahan` (`kd_perumahan`),
  ADD KEY `kd_kriteria` (`kd_kriteria`);

--
-- Indeks untuk tabel `daftar_perumahan`
--
ALTER TABLE `daftar_perumahan`
  ADD PRIMARY KEY (`nik`);

--
-- Indeks untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`kd_hasil`),
  ADD KEY `kd_perumahan` (`kd_perumahan`),
  ADD KEY `nik` (`nik`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`kd_kriteria`),
  ADD KEY `kd_perumahan` (`kd_perumahan`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`kd_nilai`),
  ADD KEY `kd_perumahan` (`kd_perumahan`),
  ADD KEY `kd_kriteria` (`kd_kriteria`),
  ADD KEY `nik` (`nik`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`kd_pengguna`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`kd_penilaian`),
  ADD KEY `kd_perumahan` (`kd_perumahan`),
  ADD KEY `kd_kriteria` (`kd_kriteria`);

--
-- Indeks untuk tabel `perumahan`
--
ALTER TABLE `perumahan`
  ADD PRIMARY KEY (`kd_perumahan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bobot`
--
ALTER TABLE `bobot`
  MODIFY `kd_bobot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `daftar_perumahan`
--
ALTER TABLE `daftar_perumahan`
  MODIFY `nik` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=987654322;

--
-- AUTO_INCREMENT untuk tabel `hasil`
--
ALTER TABLE `hasil`
  MODIFY `kd_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `kd_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `kd_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `kd_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `kd_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `perumahan`
--
ALTER TABLE `perumahan`
  MODIFY `kd_perumahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bobot`
--
ALTER TABLE `bobot`
  ADD CONSTRAINT `bobot_ibfk_1` FOREIGN KEY (`kd_perumahan`) REFERENCES `perumahan` (`kd_perumahan`),
  ADD CONSTRAINT `bobot_ibfk_2` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`);

--
-- Ketidakleluasaan untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_ibfk_1` FOREIGN KEY (`kd_perumahan`) REFERENCES `perumahan` (`kd_perumahan`),
  ADD CONSTRAINT `hasil_ibfk_2` FOREIGN KEY (`nik`) REFERENCES `daftar_perumahan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD CONSTRAINT `kriteria_ibfk_1` FOREIGN KEY (`kd_perumahan`) REFERENCES `perumahan` (`kd_perumahan`);

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`kd_perumahan`) REFERENCES `perumahan` (`kd_perumahan`),
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`),
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`nik`) REFERENCES `daftar_perumahan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`kd_perumahan`) REFERENCES `perumahan` (`kd_perumahan`),
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
