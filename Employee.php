
<!-- Hapus Data -->
<?php
// include 'connect.php';
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $data = json_decode(file_get_contents('php://input'), true);
//     $idBuruh = $data['id_buruh'];
    
//     // Gunakan prepared statement untuk mencegah SQL injection
//     $stmt = $conn->prepare($sqlDelete);
//     $stmt->bind_param("s", $idBuruh);

//     $response = ['message' => '', 'success' => false];

//     if ($stmt->execute()) {
//         $response['message'] = 'Data berhasil dihapus.';
//         $response['success'] = true;
//     } else {
//         $response['message'] = 'Gagal menghapus data: ' . $stmt->error;
//     }

//     // Tutup statement dan koneksi
//     $stmt->close();
//     $conn->close();

//     // Keluarkan hasil sebagai JSON
//     header('Content-Type: application/json');
//     echo json_encode($response);
// } else {
//     echo json_encode(['message' => 'ID tidak valid.', 'success' => false]);
// }
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

    <!-- Link Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- LINK CSS -->
    <link rel="stylesheet" href="Assets/css/style.css">
</head>

<body>
            
        <?php
        include 'connect.php';

        $Id_buruh = isset($_POST['Id_buruh']) ? $_POST['Id_buruh'] : '';
        $nama = isset($_POST['Nama']) ? $_POST['Nama'] : '';
        $jenis_kelamin = isset($_POST['Jenis_Kelamin']) ? $_POST['Jenis_Kelamin'] : '';
        $tanggal_lahir = isset($_POST['Tanggal_Lahir']) ? $_POST['Tanggal_Lahir'] : '';
        $alamat = isset($_POST['Alamat']) ? $_POST['Alamat'] : '';
        $kategori_keahlian = isset($_POST['Kategori_Keahlian']) ? $_POST['Kategori_Keahlian'] : '';

        if (empty($Id_buruh) || empty($nama) || empty($jenis_kelamin) || empty($tanggal_lahir) || empty($alamat) || empty($kategori_keahlian)) {
            // echo "Semua kolom harus diisi.";
        } else {
            $stmt = $conn->prepare("INSERT INTO tb_buruh (Id_buruh, Nama, Jenis_Kelamin, Tanggal_Lahir, Alamat, Kategori_Keahlian) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $Id_buruh, $nama, $jenis_kelamin, $tanggal_lahir, $alamat, $kategori_keahlian);

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
        <?php include 'assets/sidebar.php'; ?>
        <!-- Sidebar End -->


        <!-- Container Start-->
        <section class="hero" id="home">
            <div class="report">
                <h2>Data Buruh</h2>
                <div class="tabular--wrapper1">
                    <div class="table-container1">
                    <form action="Employee.php" method="POST">
                        <table>
                            <tbody class="form">
                                <tr class="form-1">
                                    <td class="form-1"><label for="Id_buruh">Id Buruh</label></td>
                                    <td class="form-1"> : <input type="text" id="Id_buruh" name="Id_buruh" required /></td>
                                </tr>
                                <tr class="form-1">
                                    <td class="form-1"><label for="Nama">Nama</label></td>
                                    <td class="form-1"> : <input type="text" id="Nama" name="Nama" required /></td>
                                </tr>
                                <tr class="form-1">
                                    <td class="form-1"><label for="Alamat">Alamat</label></td>
                                    <td class="form-1"> : <input type="text" id="Alamat" name="Alamat" required /></td>
                                </tr>
                                <tr class="form-1">
                                    <td class="form-1"><label for="Tanggal_Lahir">Tanggal</label></td>
                                    <td class="form-1"> : <input type="date" id="Tanggal_Lahir" name="Tanggal_Lahir" required></td>
                                </tr>
                                <tr class="form-1">
                                    <td class="form-1"><label>Jenis Kelamin</label></td>
                                    <td class="form-1"> :
                                        <input type="radio" id="laki_laki" name="Jenis_Kelamin" value="L" required>
                                        <label for="laki_laki">Laki-laki</label>
                                        <input type="radio" id="perempuan" name="Jenis_Kelamin" value="P" required>
                                        <label for="perempuan">Perempuan</label>
                                    </td>
                                </tr>
                                <tr class="form-1">
                                    <td class="form-1"><label for="kategori_keahlian">Kategori Keahlian</label></td>
                                    <td class="form-1"> :
                                        <select id="kategori_keahlian" name="Kategori_Keahlian"> <!-- Changed name attribute -->
                                            <option value="Buruh Kasar">Buruh Kasar</option>
                                            <option value="Operator">Buruh Operator</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="input">Masukkan</button>
                    </form>
                        </div>
                    </div>

                

                    <?php
                        include 'connect.php';

                        $sql_select_buruh = "SELECT * FROM tb_buruh";
                        $result_buruh = $conn->query($sql_select_buruh);

                        if ($result_buruh) {
                            echo '<div class="tabular--wrapper">
                                    <div class="table-container">
                                        <button class="view">View all</button>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>ID Buruh</th>
                                                    <th>Nama</th>
                                                    <th>Alamat</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Kategori Keahlian</th>
                                                </tr>
                                            </thead>
                                            <tbody>';

                            while ($row_buruh = $result_buruh->fetch_assoc()) {
                                echo '<tr>
                                        <td>' . $row_buruh['Id_buruh'] . '</td>
                                        <td>' . $row_buruh['Nama'] . '</td>
                                        <td>' . $row_buruh['Alamat'] . '</td>
                                        <td>' . $row_buruh['Tanggal_Lahir'] . '</td>
                                        <td>' . $row_buruh['Jenis_Kelamin'] . '</td>
                                        <td>' . $row_buruh['Kategori_Keahlian'] . '</td>
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

                <div class="images"><img src="Assets/images/Gmbr3.png" width="200">
                    <img src="Assets/images/teamwork.png" width="200">
                </div>
            </div>

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

    <!-- ICONS -->
    <script>
        feather.replace();
    </script>
</body>

</html>