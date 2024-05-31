<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing page</title>
    <!-- ICONS -->
    <link rel="icon" type="image/x-icon" href="Assets/images/Logo.png">
    <script src="https://kit.fontawesome.com/63c084cc86.js" crossorigin="anonymous"></script>
    
    <!-- Link Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- LINK CSS -->
    <link rel="stylesheet" href="Assets/css/style.css">
</head>

<body>
<?php
include 'connect.php';

$Nama = isset($_POST['Nama']) ? $_POST['Nama'] : '';
$Jam_Mulai = isset($_POST['Jam_Mulai']) ? $_POST['Jam_Mulai'] : '';
$Jam_Selesai = isset($_POST['Jam_Selesai']) ? $_POST['Jam_Selesai'] : '';
$Tanggal_Kerja = isset($_POST['Tanggal_Kerja']) ? $_POST['Tanggal_Kerja'] : '';

if (empty($Nama) || empty($Jam_Mulai) || empty($Jam_Selesai) || empty($Tanggal_Kerja)) {
    // echo "Semua kolom harus diisi.";
} else {

    $total_jam = (strtotime($Jam_Selesai) - strtotime($Jam_Mulai)) / 3600;

    $stmt = $conn->prepare("INSERT INTO tb_jam_kerja (Nama, Jam_Mulai, Jam_Selesai, Tanggal_Kerja, Total_Jam_Kerja) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $Nama, $Jam_Mulai, $Jam_Selesai, $Tanggal_Kerja, $total_jam);

    if ($stmt->execute()) {
        ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
            <script>
                toastr.options = {
                  "closeButton": true,
                  "debug": true,
                  "newestOnTop": true,
                  "progressBar": true,
                  "positionClass": "toast-top-center",
                  "preventDuplicates": true,
                  "onclick": null,
                  "showDuration": 300,
                  "hideDuration": 100,
                  "timeOut": 5000,
                  "extendedTimeOut": 1000,
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                };
                
                toastr["success"]("Berhasil");
            </script>
            <?php
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
    <!-- Header Start -->
    <?php include 'assets/header.php'; ?>
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
                            <tbody class="form">
                                <tr class="form-1">
                                    <td class="form-1">Nama</td>
                                    <td class="form-1"> : <input type="text" name="Nama" required /></td>
                                </tr>
                                <tr class="form-1">
                                    <td class="form-1">Jam Mulai</td>
                                    <td class="form-1"> : <input type="time" name="Jam_Mulai" id="Jam_Mulai" required ></td>
                                </tr>
                                <tr class="form-1">
                                    <td class="form-1">Jam Selesai</td>
                                    <td class="form-1"> : <input type="time" name="Jam_Selesai" id="Jam_Selesai" required ></td>
                                </tr>
                                <tr class="form-1">
                                    <td class="form-1">Tanggal Kerja</td>
                                    <td class="form-1"> : <input type="date" name="Tanggal_Kerja" required></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="input">Submit</button>
                    </form>

                    </div>
                    <script>
                        function getCurrentTime() {
                            const now = new Date();
                            const hours = now.getHours().toString().padStart(2, '0');
                            const minutes = now.getMinutes().toString().padStart(2, '0');
                            return `${hours}:${minutes}`;
                        }

                        document.addEventListener('DOMContentLoaded', function () {
                            const jamMulaiInput = document.getElementById('Jam_Mulai');
                            jamMulaiInput.value = "07:00";
                            const jamSelesaiInput = document.getElementById('Jam_Selesai');
                            jamSelesaiInput.value = getCurrentTime();
                        });
                    </script>
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
                                                    <th>Nama</th>
                                                    <th>Jam Mulai</th>
                                                    <th>Jam Selesai</th>
                                                    <th>Tanggal</th>
                                                    <th>Total Jam Kerja</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                            while ($row_jamkerja = $result_jamkerja->fetch_assoc()) {
                                echo '<tr>
                                        <td>' . $row_jamkerja['Id_JamKerja'] . '</td>
                                        <td>' . $row_jamkerja['Nama'] . '</td>
                                        <td>' . $row_jamkerja['Jam_Mulai'] . '</td>
                                        <td>' . $row_jamkerja['Jam_Selesai'] . '</td>
                                        <td>' . $row_jamkerja['Tanggal_Kerja'] . '</td>
                                        <td>' . $row_jamkerja['Total_Jam_Kerja'] . ' jam</td>
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
    <?php include 'assets/footer.php'; ?>
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