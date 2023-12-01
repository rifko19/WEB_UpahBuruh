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
</head>

<body>
    <!-- Header Start -->
    <div class="header">
        <header class="header-top">
            <div href="#" class="logo">
                <img src="Assets/images/Logo.png" width="60"><a href="#">Pabrik Batta</a>
            </div>

            <div class="navbar-btn">
                <a href="#home" class="active"><i class="fa-regular fa-bell fa-2xl"></i></a>
                <a href="Login-page.html" class="active"><i class="fa-regular fa-circle-user fa-2xl"></i></a>
            </div>
        </header>

    </div>
    <!-- Header End -->
    <div class="container">
        <!-- Sidebar Start -->
        <div class="sidebar">
            <ul class="nav">
                <li><a href="Home-page.html"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="Report.php"><i class="fa fa-file"></i>Report</a></li>
                <li><a href="Time-Management.php"><i class="fa fa-calendar-days"></i>Time Management</a></li>
                <li><a href="Employee.php"><i class="fa fa-address-card"></i>Employee data</a></li>
                <li><a href="Payroll.php"><i class="fa fa-address-card"></i>Payroll</a></li>
                <li><a href="#"><i class="fa fa-right-from-bracket"></i>Log-Out</a></li>
            </ul>
        </div>
        <!-- Sidebar End -->


        <!-- Container Start-->
        <section class="hero" id="home">
            <div class="report">
                <h2>Laporan Karyawan</h2>
                <?php
                    include 'connect.php';
                    $sql_select_laporan = "SELECT * FROM view_laporan3";
                    $result_laporan = $conn->query($sql_select_laporan);

                    if ($result_laporan) {
                        echo '<div class="tabular--wrapper">
                                <div class="table-container">
                                    <button class="view">View all</button>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID Laporan</th>
                                                <th>Nama Buruh</th>
                                                <th>Kategori Keahlian</th>
                                                <th>Total Kerja</th>
                                                <th>Tanggal Kerja</th>
                                                <th>Gaji Buruh Lepas</th>
                                                <th>Gaji Operator</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                        while ($row_laporan = $result_laporan->fetch_assoc()) {
                            echo '<tr>
                                    <td>' . $row_laporan['id_Laporan'] . '</td>
                                    <td>' . $row_laporan['Nama_Buruh'] . '</td>
                                    <td>' . $row_laporan['Kategori_Keahlian'] . '</td>
                                    <td>' . $row_laporan['TotalJamKerja'] . '</td>
                                    <td>' . $row_laporan['Tanggal_Kerja'] . '</td>
                                    <td>' . $row_laporan['GajiBuruhLepas'] . '</td>
                                    <td>' . $row_laporan['GajiOperator'] . '</td>
                                </tr>';
                        }

                        echo '</tbody>
                            </table>
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
    <footer class="footer-distributed">

        <div class="footer-left">
            <img class="Unsri" src="Assets/images/UnsriLogo.png">
            <img class="PB" src="Assets/images/Logo.png">
            <h3>UNSRI | <span> Batta</span></h3>

            <p class="footer-company-name">Copyright by Kelompok 5.</p>
        </div>

        <div class="footer-center">
            <div>
                <i class="fa fa-map-pin"></i>
                <p>Fasilkom Unsri bukit</p>
            </div>

            <div>
                <i class="fa fa-phone"></i>
                <p>+628 2181 6824 61</p>
            </div>
            <div>
                <i class="fa fa-envelope"></i>
                <p><a href="mailto:kelompok5@gmail.com">kelompok5@gmail.com</a></p>
            </div>
        </div>
        <div class="footer-right">
            <p class="footer-company-about">
                <span>About the company</span>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime cupiditate at recusandae distinctio
                veritatis doloremque doloribus quam libero facilis mollitia similique pariatur ex voluptates aut dolor,
                corporis rem totam laborum.
            </p>
            <div class="footer-icons">
                <a href="https://github.com/rifko19?tab=repositories"><i class="fa fa-github"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>
    </footer>
    <!-- Footer End-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- ICONS -->
    <script>
        feather.replace();
    </script>
</body>

</html>