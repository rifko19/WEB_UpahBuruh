-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Bulan Mei 2024 pada 11.59
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_upahburuh`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_buruh`
--

CREATE TABLE `tb_buruh` (
  `Id_buruh` varchar(11) NOT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `Jenis_Kelamin` varchar(1) DEFAULT NULL,
  `Tanggal_Lahir` date DEFAULT NULL,
  `Alamat` text DEFAULT NULL,
  `Kategori_Keahlian` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_buruh`
--

INSERT INTO `tb_buruh` (`Id_buruh`, `Nama`, `Jenis_Kelamin`, `Tanggal_Lahir`, `Alamat`, `Kategori_Keahlian`) VALUES
('B1', 'Indira naylah', 'P', '2004-10-19', 'Plaju Yaktapena', 'Buruh Kasar'),
('B11', 'Shinta', 'L', '2004-05-22', 'Tegal', 'Buruh Kasar'),
('B2', 'Dejet Kiya', 'P', '2005-04-22', 'Parameswara', 'Operator'),
('B3', 'Rifko Akbar', 'L', '2003-07-19', 'Pakjo Talang Ratu', 'Operator'),
('B4', 'Farhan', 'L', '2004-12-22', 'Kenten', 'Operator'),
('B5', 'Yanto', 'L', '1977-08-21', 'Padang Selasa', 'Buruh Kasar'),
('B6', 'Super Dede', 'P', '1960-08-21', 'Poligon', 'Buruh Kasar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_gaji`
--

CREATE TABLE `tb_gaji` (
  `Id_gaji` int(4) UNSIGNED ZEROFILL NOT NULL,
  `Gaji_buruh_kasar` double DEFAULT NULL,
  `Gaji_Operator` double DEFAULT NULL,
  `Tanggal_Kerja` date DEFAULT NULL,
  `Id_Buruh` varchar(11) DEFAULT NULL,
  `Id_JamKerja` int(4) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_gaji`
--

INSERT INTO `tb_gaji` (`Id_gaji`, `Gaji_buruh_kasar`, `Gaji_Operator`, `Tanggal_Kerja`, `Id_Buruh`, `Id_JamKerja`) VALUES
(0005, 160000, 0, '2022-02-20', 'B1', 0019),
(0006, 0, 280000, '2023-06-19', 'B2', 0020),
(0007, 0, 280000, '2023-07-25', 'B3', 0021),
(0008, 0, 385000, '2024-07-25', 'B4', 0022),
(0009, 200000, 0, '2023-02-25', 'B5', 0023),
(0010, 160000, 0, '2023-02-25', 'B6', 0024),
(0022, 0, 385000, '2023-07-26', 'B3', 0036),
(0031, 0, 350000, '2024-05-23', 'B3', 0045);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jam_kerja`
--

CREATE TABLE `tb_jam_kerja` (
  `Id_JamKerja` int(4) UNSIGNED ZEROFILL NOT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `Jam_Mulai` time DEFAULT NULL,
  `Jam_Selesai` time DEFAULT NULL,
  `Tanggal_Kerja` date DEFAULT NULL,
  `Total_Jam_Kerja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_jam_kerja`
--

INSERT INTO `tb_jam_kerja` (`Id_JamKerja`, `Nama`, `Jam_Mulai`, `Jam_Selesai`, `Tanggal_Kerja`, `Total_Jam_Kerja`) VALUES
(0019, 'Indira naylah', '08:00:00', '16:00:00', '2022-02-20', 8),
(0020, 'Dejet Kiya', '09:00:00', '17:00:00', '2023-06-19', 8),
(0021, 'Rifko Akbar', '07:00:00', '15:00:00', '2023-07-25', 8),
(0022, 'Farhan', '08:00:00', '19:00:00', '2024-07-25', 11),
(0023, 'Yanto', '07:00:00', '17:00:00', '2023-02-25', 10),
(0024, 'Super Dede', '06:00:00', '14:00:00', '2023-02-25', 8),
(0036, 'Rifko Akbar', '06:00:00', '17:00:00', '2023-07-26', 11),
(0045, 'Rifko Akbar', '07:00:00', '16:58:00', '2024-05-23', 10);

--
-- Trigger `tb_jam_kerja`
--
DELIMITER $$
CREATE TRIGGER `hitung_gaji` AFTER INSERT ON `tb_jam_kerja` FOR EACH ROW BEGIN
    DECLARE gaji DOUBLE;
    IF NEW.Nama IN (SELECT Nama FROM tb_buruh WHERE Kategori_Keahlian = 'Buruh Kasar') THEN
        SET gaji = NEW.Total_Jam_Kerja * 20000;
    ELSE
        SET gaji = NEW.Total_Jam_Kerja * 35000;
    END IF;
    
INSERT INTO tb_gaji (Gaji_buruh_kasar, Gaji_Operator, Tanggal_Kerja, Id_Buruh, Id_JamKerja)
    VALUES (CASE WHEN NEW.Nama IN (SELECT Nama FROM tb_buruh WHERE Kategori_Keahlian = 'Buruh Kasar') THEN gaji ELSE 0 END,
            CASE WHEN NEW.Nama NOT IN (SELECT Nama FROM tb_buruh WHERE Kategori_Keahlian = 'Buruh Kasar') THEN gaji ELSE 0 END,
            NEW.Tanggal_Kerja,
            (SELECT Id_buruh FROM tb_buruh WHERE Nama = NEW.Nama),
            NEW.Id_JamKerja);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hitung_total_jam_kerja` BEFORE INSERT ON `tb_jam_kerja` FOR EACH ROW BEGIN
    DECLARE total_jam INT;
    SET total_jam = TIMESTAMPDIFF(SECOND, NEW.Jam_Mulai, NEW.Jam_Selesai) / 3600;
    SET NEW.Total_Jam_Kerja = total_jam;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_gaji_karyawan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_gaji_karyawan` (
`Nama` varchar(100)
,`Kategori_Keahlian` varchar(30)
,`Gaji` double
,`Tanggal_Kerja` date
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_gaji_karyawan2`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_gaji_karyawan2` (
`Nama` varchar(100)
,`Kategori_Keahlian` varchar(30)
,`Bulan` int(2)
,`Tahun` int(4)
,`Total_Gaji` double
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_gaji_karyawan`
--
DROP TABLE IF EXISTS `view_gaji_karyawan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_gaji_karyawan`  AS SELECT `b`.`Nama` AS `Nama`, `b`.`Kategori_Keahlian` AS `Kategori_Keahlian`, CASE WHEN `b`.`Kategori_Keahlian` = 'Buruh Kasar' THEN `g`.`Gaji_buruh_kasar` ELSE `g`.`Gaji_Operator` END AS `Gaji`, `g`.`Tanggal_Kerja` AS `Tanggal_Kerja` FROM (`tb_buruh` `b` join `tb_gaji` `g` on(`b`.`Id_buruh` = `g`.`Id_Buruh`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_gaji_karyawan2`
--
DROP TABLE IF EXISTS `view_gaji_karyawan2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_gaji_karyawan2`  AS SELECT `tb_buruh`.`Nama` AS `Nama`, `tb_buruh`.`Kategori_Keahlian` AS `Kategori_Keahlian`, month(`tb_gaji`.`Tanggal_Kerja`) AS `Bulan`, year(`tb_gaji`.`Tanggal_Kerja`) AS `Tahun`, sum(case when `tb_buruh`.`Kategori_Keahlian` = 'Buruh Kasar' then `tb_gaji`.`Gaji_buruh_kasar` else `tb_gaji`.`Gaji_Operator` end) AS `Total_Gaji` FROM (`tb_buruh` join `tb_gaji` on(`tb_buruh`.`Id_buruh` = `tb_gaji`.`Id_Buruh`)) GROUP BY `tb_buruh`.`Nama`, `tb_buruh`.`Kategori_Keahlian`, month(`tb_gaji`.`Tanggal_Kerja`), year(`tb_gaji`.`Tanggal_Kerja`) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_buruh`
--
ALTER TABLE `tb_buruh`
  ADD PRIMARY KEY (`Id_buruh`),
  ADD KEY `idx_nama` (`Nama`);

--
-- Indeks untuk tabel `tb_gaji`
--
ALTER TABLE `tb_gaji`
  ADD PRIMARY KEY (`Id_gaji`),
  ADD KEY `fk_tb_gaji_tb_buruh` (`Id_Buruh`),
  ADD KEY `fk_id_jamKerja` (`Id_JamKerja`);

--
-- Indeks untuk tabel `tb_jam_kerja`
--
ALTER TABLE `tb_jam_kerja`
  ADD PRIMARY KEY (`Id_JamKerja`),
  ADD KEY `FK_tb_jam_kerja_Nama` (`Nama`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_gaji`
--
ALTER TABLE `tb_gaji`
  MODIFY `Id_gaji` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `tb_jam_kerja`
--
ALTER TABLE `tb_jam_kerja`
  MODIFY `Id_JamKerja` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_gaji`
--
ALTER TABLE `tb_gaji`
  ADD CONSTRAINT `fk_id_buruh` FOREIGN KEY (`Id_Buruh`) REFERENCES `tb_buruh` (`Id_buruh`),
  ADD CONSTRAINT `fk_id_jamKerja` FOREIGN KEY (`Id_JamKerja`) REFERENCES `tb_jam_kerja` (`Id_JamKerja`),
  ADD CONSTRAINT `fk_tb_gaji_tb_buruh` FOREIGN KEY (`Id_Buruh`) REFERENCES `tb_buruh` (`Id_buruh`);

--
-- Ketidakleluasaan untuk tabel `tb_jam_kerja`
--
ALTER TABLE `tb_jam_kerja`
  ADD CONSTRAINT `FK_tb_jam_kerja_Nama` FOREIGN KEY (`Nama`) REFERENCES `tb_buruh` (`Nama`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
