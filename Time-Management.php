<?php
include 'connect.php'; 

$id_JamKerja = str_pad(mt_rand(0, 10000), 6, '0', STR_PAD_LEFT);
$jam_mulai = isset($_POST['jam_mulai']) ? $_POST['jam_mulai'] : '';
$jam_selesai = isset($_POST['jam_selesai']) ? $_POST['jam_selesai'] : '';
$tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';
$id_buruh = isset($_POST['id_buruh']) ? $_POST['id_buruh'] : '';

if (empty($id_buruh) || empty($jam_mulai) || empty($jam_selesai) || empty($tanggal)) {
    // echo "Semua kolom harus diisi.";
} else {
    $sql_insert = "INSERT INTO tb_jam_kerja (id_buruh, id_JamKerja, jam_mulai, jam_selesai, tanggal)
                   VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("sssss", $id_buruh, $id_JamKerja, $jam_mulai, $jam_selesai, $tanggal);
    
    if ($stmt->execute()) {
        echo "Data jam kerja berhasil dimasukkan.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>




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
                <h2>Jam Kerja</h2>
                <div class="tabular--wrapper1">
                    <div class="table-container1">
                        <form action="Time-Management.php" method="POST">
                            <table>
                                <thead>
                                    <tbody class="form">
                                        <tr class="form-1">
                                            <td class="form-1">ID Jam Kerja</td>
                                            <td class="form-1"> : <input type="text" name="id_JamKerja" value="<?php echo str_pad(mt_rand(0, 10000), 6, '0', STR_PAD_LEFT); ?>" readonly />
                                            </td>
                                        </tr>
                                        <tr class="form-1">
                                            <td class="form-1">Jam mulai</td>
                                            <td class="form-1"> : <input type="time" name="jam_mulai" required readonly/>
                                            </td>
                                        </tr>
                                        <tr class="form-1">
                                            <td class="form-1">Jam selesai</td>
                                            <td class="form-1"> : <input type="time" name="jam_selesai" required/>
                                            </td>
                                        </tr>
                                        <tr class="form-1">
                                            <td class="form-1">Tanggal Kerja</td>
                                            <td class="form-1"> : <input type="date" name="tanggal" required></td>
                                        </tr>
                                        <tr class="form-1">
                                            <td class="form-1">ID Buruh</td>
                                            <td class="form-1"> : <input type="text" name="id_buruh" required />
                                            </td>
                                        </tr>
                                    </tbody>
                                </thead>
                            </table>
                            <button type="submit" class="input">Hitung</button>
                        </form>

                    </div>

                    <?php
                        include 'connect.php';
                        $sql_select_jamkerja = "SELECT * FROM tb_jam_kerja";
                        $result_jamkerja = $conn->query($sql_select_jamkerja);

                        if ($result_jamkerja) {
                            echo '<div class="tabular--wrapper">
                                    <div class="table-container">
                                        <button class="view">View all</button>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>ID Jam Kerja</th>
                                                    <th>Jam Mulai</th>
                                                    <th>Jam Selesai</th>
                                                    <th>Tanggal</th>
                                                    <th>Total Jam Kerja</th>
                                                    <th>ID Buruh</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                            while ($row_jamkerja = $result_jamkerja->fetch_assoc()) {
                                echo '<tr>
                                        <td>' . $row_jamkerja['id_JamKerja'] . '</td>
                                        <td>' . $row_jamkerja['Jam_Mulai'] . '</td>
                                        <td>' . $row_jamkerja['Jam_Selesai'] . '</td>
                                        <td>' . $row_jamkerja['Tanggal'] . '</td>
                                        <td>' . $row_jamkerja['TotalJamKerja'] . ' jam</td>
                                        <td>' . $row_jamkerja['id_buruh'] . '</td>
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
                <a href="https://www.linkedin.com/in/rifko-akbar-592915249/"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>
    </footer>
    <!-- Footer End-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- Library js -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="Assets/JS/script.js"></script>
    <!-- jQuery -->

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.all.min.js"></script>
    
    <!-- ICONS -->
    <script>
        feather.replace();
    </script>
</body>

</html>