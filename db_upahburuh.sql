-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Nov 2023 pada 15.11
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
  `id_buruh` varchar(20) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Alamat` varchar(100) NOT NULL,
  `Jenis_Kelamin` varchar(100) NOT NULL,
  `Tanggal_Lahir` date NOT NULL,
  `Kategori_Keahlian` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_buruh`
--

INSERT INTO `tb_buruh` (`id_buruh`, `Nama`, `Alamat`, `Jenis_Kelamin`, `Tanggal_Lahir`, `Kategori_Keahlian`) VALUES
('000746', 'Julia Akbar', 'Km 12', 'Perempuan', '1981-01-01', 'Buruh Kasar'),
('001006', 'Abdul Muhap', 'Plaju', 'Laki-laki', '1999-07-17', 'Buruh Operator'),
('002093', 'Agus Slamet', 'Kenten', 'Laki-laki', '1985-08-01', 'Buruh Kasar'),
('008753', 'Siti Nuraini', 'Kertapati', 'Perempuan', '1980-10-19', 'Buruh Operator'),
('020139', 'Rifko Akbar', 'Talang Ratu', 'Laki-laki', '2003-07-19', 'Buruh Operator'),
('025540', 'Farhan Prasetyo', 'Padang Selaso', 'Laki-laki', '1990-11-01', 'Buruh Kasar'),
('025934', 'Dilak', 'Km 12', 'Perempuan', '1992-01-30', 'Buruh Operator'),
('026510', 'Aliyak', 'Kenten', 'Perempuan', '1999-05-20', 'Buruh Kasar');

--
-- Trigger `tb_buruh`
--
DELIMITER $$
CREATE TRIGGER `after_delete_tb_buruh` AFTER DELETE ON `tb_buruh` FOR EACH ROW BEGIN
    -- Menghapus data pada tabel tb_jam_kerja yang terkait
    DELETE FROM tb_jam_kerja WHERE id_buruh = OLD.id_buruh;

    -- Menghapus data pada tabel tb_gaji yang terkait
    DELETE FROM tb_gaji WHERE id_buruh = OLD.id_buruh;

    -- Menghapus data pada tabel tb_laporan yang terkait
    DELETE FROM tb_laporan WHERE id_buruh = OLD.id_buruh;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_gaji`
--

CREATE TABLE `tb_gaji` (
  `id_Gaji` varchar(20) NOT NULL,
  `GajiBuruhLepas` int(11) DEFAULT NULL,
  `GajiOperator` int(11) DEFAULT NULL,
  `id_buruh` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_gaji`
--

INSERT INTO `tb_gaji` (`id_Gaji`, `GajiBuruhLepas`, `GajiOperator`, `id_buruh`) VALUES
('031820', NULL, 390000, '020139'),
('035369', 135000, NULL, '002093'),
('037089', 165000, NULL, '025540'),
('037439', NULL, 330000, '008753'),
('039151', NULL, 360000, '001006');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jam_kerja`
--

CREATE TABLE `tb_jam_kerja` (
  `id_JamKerja` varchar(20) NOT NULL,
  `Jam_Mulai` time NOT NULL,
  `Jam_Selesai` time NOT NULL,
  `Tanggal` date NOT NULL,
  `TotalJamKerja` int(11) DEFAULT NULL,
  `id_buruh` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_jam_kerja`
--

INSERT INTO `tb_jam_kerja` (`id_JamKerja`, `Jam_Mulai`, `Jam_Selesai`, `Tanggal`, `TotalJamKerja`, `id_buruh`) VALUES
('004643', '06:15:00', '19:30:00', '2023-11-12', 13, '020139'),
('005095', '07:30:00', '19:00:00', '2023-11-27', 11, '025540'),
('006301', '07:00:00', '18:00:00', '2023-11-10', 11, '008753'),
('007784', '07:00:00', '16:00:00', '2023-11-10', 9, '002093'),
('008294', '08:00:00', '20:00:00', '2023-11-10', 12, '001006');

--
-- Trigger `tb_jam_kerja`
--
DELIMITER $$
CREATE TRIGGER `after_insert_tb_jam_kerja` AFTER INSERT ON `tb_jam_kerja` FOR EACH ROW BEGIN
    -- Cek apakah data dengan id_JamKerja yang baru diinsert sudah ada di tb_laporan
    IF NOT EXISTS (
        SELECT 1
        FROM tb_laporan
        WHERE id_JamKerja = NEW.id_JamKerja
    ) THEN
        -- Jika belum ada, masukkan data ke tb_laporan
        INSERT INTO tb_laporan (id_Laporan, Kategori_Keahlian, id_buruh, id_JamKerja, id_Gaji)
        SELECT 
            CONCAT('L', LPAD(FLOOR(RAND() * 10000), 4, '0')),
            tb_buruh.Kategori_Keahlian,
            tb_buruh.id_buruh,
            tb_jam_kerja.id_JamKerja,
            tb_gaji.id_Gaji
        FROM 
            tb_buruh
            JOIN tb_jam_kerja ON tb_buruh.id_buruh = tb_jam_kerja.id_buruh
            JOIN tb_gaji ON tb_buruh.id_buruh = tb_gaji.id_buruh
        WHERE 
            tb_jam_kerja.id_JamKerja = NEW.id_JamKerja
            AND tb_gaji.id_buruh = NEW.id_buruh;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tb_JamKerja_BEFORE_INSERT` BEFORE INSERT ON `tb_jam_kerja` FOR EACH ROW BEGIN
    -- Hitung TotalJamKerja berdasarkan Jam_Mulai dan Jam_Selesai
    SET NEW.TotalJamKerja = TIMESTAMPDIFF(HOUR, NEW.Jam_Mulai, NEW.Jam_Selesai);

    -- Insert atau update ke tb_Gaji
    INSERT INTO tb_Gaji (id_Gaji, GajiBuruhLepas, GajiOperator, id_buruh)
    VALUES
        (CONCAT('03', LPAD(FLOOR(RAND() * 10000), 4, '0')), CASE WHEN (SELECT Kategori_Keahlian FROM tb_Buruh WHERE id_buruh = NEW.id_buruh) = 'Buruh Kasar' THEN NEW.TotalJamKerja * 15000 ELSE NULL END,
         CASE WHEN (SELECT Kategori_Keahlian FROM tb_Buruh WHERE id_buruh = NEW.id_buruh) = 'Buruh Operator' THEN NEW.TotalJamKerja * 30000 ELSE NULL END,
         NEW.id_buruh);

    -- Hapus baris dengan nilai NULL (jika diperlukan)
    DELETE FROM tb_Gaji WHERE GajiBuruhLepas IS NULL AND GajiOperator IS NULL;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_laporan`
--

CREATE TABLE `tb_laporan` (
  `id_Laporan` varchar(20) NOT NULL,
  `Kategori_Keahlian` varchar(100) NOT NULL,
  `id_buruh` varchar(20) DEFAULT NULL,
  `id_JamKerja` varchar(20) DEFAULT NULL,
  `id_Gaji` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_laporan`
--

INSERT INTO `tb_laporan` (`id_Laporan`, `Kategori_Keahlian`, `id_buruh`, `id_JamKerja`, `id_Gaji`) VALUES
('L0164', 'Buruh Kasar', '025540', '005095', '037089'),
('L0343', 'Buruh Operator', '001006', '008294', '039151'),
('L1211', 'Buruh Operator', '008753', '006301', '037439'),
('L5168', 'Buruh Operator', '020139', '004643', '031820'),
('L8448', 'Buruh Kasar', '002093', '007784', '035369');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_laporan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_laporan` (
`id_Laporan` varchar(20)
,`Kategori_Keahlian` varchar(100)
,`Nama_Buruh` varchar(100)
,`Jam_Mulai` time
,`Jam_Selesai` time
,`Tanggal_JamKerja` date
,`GajiBuruhLepas` int(11)
,`GajiOperator` int(11)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_laporan`
--
DROP TABLE IF EXISTS `view_laporan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan`  AS SELECT `tb_laporan`.`id_Laporan` AS `id_Laporan`, `tb_laporan`.`Kategori_Keahlian` AS `Kategori_Keahlian`, `tb_buruh`.`Nama` AS `Nama_Buruh`, `tb_jam_kerja`.`Jam_Mulai` AS `Jam_Mulai`, `tb_jam_kerja`.`Jam_Selesai` AS `Jam_Selesai`, `tb_jam_kerja`.`Tanggal` AS `Tanggal_JamKerja`, `tb_gaji`.`GajiBuruhLepas` AS `GajiBuruhLepas`, `tb_gaji`.`GajiOperator` AS `GajiOperator` FROM (((`tb_laporan` left join `tb_buruh` on(`tb_laporan`.`id_buruh` = `tb_buruh`.`id_buruh`)) left join `tb_jam_kerja` on(`tb_laporan`.`id_JamKerja` = `tb_jam_kerja`.`id_JamKerja`)) left join `tb_gaji` on(`tb_laporan`.`id_Gaji` = `tb_gaji`.`id_Gaji`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_buruh`
--
ALTER TABLE `tb_buruh`
  ADD PRIMARY KEY (`id_buruh`);

--
-- Indeks untuk tabel `tb_gaji`
--
ALTER TABLE `tb_gaji`
  ADD PRIMARY KEY (`id_Gaji`),
  ADD KEY `id_buruh` (`id_buruh`);

--
-- Indeks untuk tabel `tb_jam_kerja`
--
ALTER TABLE `tb_jam_kerja`
  ADD PRIMARY KEY (`id_JamKerja`),
  ADD KEY `id_buruh` (`id_buruh`);

--
-- Indeks untuk tabel `tb_laporan`
--
ALTER TABLE `tb_laporan`
  ADD PRIMARY KEY (`id_Laporan`),
  ADD KEY `id_buruh` (`id_buruh`),
  ADD KEY `id_JamKerja` (`id_JamKerja`),
  ADD KEY `id_Gaji` (`id_Gaji`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_gaji`
--
ALTER TABLE `tb_gaji`
  ADD CONSTRAINT `tb_gaji_ibfk_1` FOREIGN KEY (`id_buruh`) REFERENCES `tb_buruh` (`id_buruh`);

--
-- Ketidakleluasaan untuk tabel `tb_jam_kerja`
--
ALTER TABLE `tb_jam_kerja`
  ADD CONSTRAINT `tb_jam_kerja_ibfk_1` FOREIGN KEY (`id_buruh`) REFERENCES `tb_buruh` (`id_buruh`);

--
-- Ketidakleluasaan untuk tabel `tb_laporan`
--
ALTER TABLE `tb_laporan`
  ADD CONSTRAINT `tb_laporan_ibfk_1` FOREIGN KEY (`id_buruh`) REFERENCES `tb_buruh` (`id_buruh`),
  ADD CONSTRAINT `tb_laporan_ibfk_2` FOREIGN KEY (`id_JamKerja`) REFERENCES `tb_jam_kerja` (`id_JamKerja`),
  ADD CONSTRAINT `tb_laporan_ibfk_3` FOREIGN KEY (`id_Gaji`) REFERENCES `tb_gaji` (`id_Gaji`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
