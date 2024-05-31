<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing page</title>
    <!-- ICONS -->
    <link rel="icon" type="image/x-icon" href="Assets/images/Logo.png">
    <script src="https://kit.fontawesome.com/63c084cc86.js" crossorigin="anonymous"></script>

    <!-- LINK CSS -->
    <link rel="stylesheet" href="Assets/css/style.css">
    
    <!-- Link tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <!-- Header Start -->
    <?php include 'assets/Header.php'; ?>
    <!-- Header End -->
    <div class="container">
        <!-- Sidebar Start -->
        <?php include 'assets/sidebar.php'; ?>
        <!-- Sidebar End -->




        <!-- Container Start-->
        <section class="hero" id="home">
            <div class="report">
            <div style="text-align: center; margin-top: 50px;">
        <div style="text-align: center; margin-top: 50px;">
            </div>

    <!-- Data Gaji Perbulan Hide -->
    <div id="data-gaji-perbulan" style="display: none;">
        <h2>Data Gaji per Bulan</h2>
        <div class="tabular--wrapper">
        <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-md">
            <form action="" method="post">
                <div class="flex">
                    <input type="text" name="keyword" placeholder="Search..." autocomplete="off" class="w-full p-2 border border-gray-300
                    rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <button type="submit" name="cari_perbulan" class="p-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600">Search</button>
                </div>
            </form>
        </div>
            <div class="table-container">
            <button class="view" type="button" id="kembali" style="margin-top: 20px;">Kembali</button>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kategori Keahlian</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Total Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'connect.php';
                        if(isset($_POST["cari_perbulan"])) {
                            $keyword = $_POST["keyword"];
                            $sql = "SELECT * FROM view_gaji_karyawan2
                                    WHERE Nama LIKE '%$keyword%'
                                    OR Kategori_Keahlian LIKE '%$keyword%'
                                    OR Bulan LIKE '%$keyword%'
                                    OR Tahun LIKE '%$keyword%'
                                    OR Total_Gaji LIKE '%$keyword%'";
                        } else {
                            $sql = "SELECT * FROM view_gaji_karyawan2";
                        }
                        $bulan = array(
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember'
                        ); 
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            // Loop untuk menampilkan data
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['Nama'] . "</td>";
                                echo "<td>" . $row['Kategori_Keahlian'] . "</td>";
                                echo "<td>" . $bulan[$row['Bulan']] . "</td>";
                                echo "<td>" . $row['Tahun'] . "</td>";
                                echo "<td>" . $row['Total_Gaji'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Tidak ada data gaji.</td></tr>";
                        }
                        // Tutup koneksi database
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

            <!-- Data Gaji pertanggal -->
                <?php
                    include 'connect.php';
                    if(isset($_POST["cari_pertanggal"])) {
                        $keyword = $_POST["keyword"];
                        $sql_select_gaji = "SELECT * FROM View_Gaji_Karyawan WHERE Nama LIKE '%$keyword%' 
                                            OR Kategori_Keahlian LIKE '%$keyword%'
                                            OR Gaji LIKE '%$keyword%'
                                            OR Tanggal_Kerja LIKE '%$keyword%'";
                    } else {
                        $sql_select_gaji = "SELECT * FROM View_Gaji_Karyawan";
                    }
                    $result_gaji = $conn->query($sql_select_gaji);

                    if ($result_gaji) {
                        echo '
                        <div id="data-gaji">
                        <h2>Laporan Karyawan</h2>
                        <div class="tabular--wrapper">
                        <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-md">
                            <form action="" method="post">
                                <div class="flex">
                                    <input type="text" name="keyword" placeholder="Search..." autocomplete="off" class="w-full p-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <button type="submit" name="cari_pertanggal" class="p-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600">Search</button>
                                </div>
                            </form>
                        </div>
                                <div class="table-container">
                                    <button class="view" type="button" id="tampilkan" style="margin-top: 20px;">Filter Perbulan</button>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Kategori Buruh</th>
                                                <th>Gaji</th>
                                                <th>Tanggal Kerja</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                        while ($row_gaji = $result_gaji->fetch_assoc()) {
                            echo '<tr>
                                    <td>' . $row_gaji['Nama'] . '</td>
                                    <td>' . $row_gaji['Kategori_Keahlian'] . '</td>
                                    <td>' . $row_gaji['Gaji'] . '</td>
                                    <td>' . $row_gaji['Tanggal_Kerja'] . '</td>
                                </tr>';
                        }

                        echo '</tbody>
                            </table>
                        </div>
                    </div>
                    </div>';
                    } else {
                        echo "Error: " . $conn->error;
                    }
                    $conn->close();
                    ?>


                <div class="images"><img src="Assets/images/schedule.png" width="200">
                    <img src="Assets/images/Gmbr2.png" width="200">
                </div>
            </div>

        </section>
        <!-- Container End-->
    </div>
    <!-- Footer Start-->
    <?php include 'assets/footer.php'; ?>
    <!-- Footer End-->

    <script>
    document.getElementById("tampilkan").addEventListener("click", function() {
    document.getElementById("data-gaji-perbulan").style.display = "block";
    });
    document.getElementById("tampilkan").addEventListener("click", function() {
        document.getElementById("data-gaji").style.display = "none";
    });

    document.getElementById("kembali").addEventListener("click", function() {
        document.getElementById("data-gaji-perbulan").style.display = "none";
    });
    document.getElementById("kembali").addEventListener("click", function() {
        document.getElementById("data-gaji").style.display = "block";
    });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- ICONS -->
    <script>
        feather.replace();
    </script>
</body>

</html>