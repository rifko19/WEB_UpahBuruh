<?php
include 'connect.php';

$nama = isset($_POST['nama']) ? $_POST['nama'] : '';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
$tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';
$jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
$kategori_keahlian = isset($_POST['kategori_keahlian']) ? $_POST['kategori_keahlian'] : '';

if (empty($nama) || empty($alamat) || empty($tanggal) || empty($jenis_kelamin) || empty($kategori_keahlian)) {
    // echo "Semua kolom harus diisi.";
} else {
   
    $stmt = $conn->prepare("INSERT INTO tb_buruh (id_buruh, Nama, Alamat, Jenis_Kelamin, Tanggal_Lahir, Kategori_Keahlian) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $id_buruh, $nama, $alamat, $jenis_kelamin, $tanggal, $kategori_keahlian);


    $id_buruh = date('YmdHis');

    if ($stmt->execute()) {
        // echo "Data berhasil dimasukkan.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

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
                <h2>Data Buruh</h2>
                <div class="tabular--wrapper1">
                    <div class="table-container1">
                            <form action="Employee.php" method="POST">
                                    <table>
                                        <tbody class="form">
                                            <tr class="form-1">
                                                <td class="form-1"><label for="nama">Nama</label></td>
                                                <td class="form-1"> : <input type="text" id="nama" name="nama" required /></td>
                                            </tr>
                                            <tr class="form-1">
                                                <td class="form-1"><label for="alamat">Alamat</label></td>
                                                <td class="form-1"> : <input type="text" id="alamat" name="alamat" required /></td>
                                            </tr>
                                            <tr class="form-1">
                                                <td class="form-1"><label for="tanggal">Tanggal</label></td>
                                                <td class="form-1"> : <input type="date" id="tanggal" name="tanggal" required></td>
                                            </tr>
                                            <tr class="form-1">
                                                <td class="form-1"><label>Jenis Kelamin</label></td>
                                                <td class="form-1"> :
                                                    <input type="radio" id="laki_laki" name="jenis_kelamin" value="Laki-laki" required>
                                                    <label for="laki_laki">Laki-laki</label>
                                                    <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan" required>
                                                    <label for="perempuan">Perempuan</label>
                                                </td>
                                            </tr>
                                            <tr class="form-1">
                                                <td class="form-1"><label for="kategori_keahlian">Kategori Keahlian</label></td>
                                                <td class="form-1"> :
                                                    <select id="kategori_keahlian" name="kategori_keahlian">
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
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>';

                            while ($row_buruh = $result_buruh->fetch_assoc()) {
                                echo '<tr>
                                        <td>' . $row_buruh['id_buruh'] . '</td>
                                        <td>' . $row_buruh['Nama'] . '</td>
                                        <td>' . $row_buruh['Alamat'] . '</td>
                                        <td>' . $row_buruh['Tanggal_Lahir'] . '</td>
                                        <td>' . $row_buruh['Jenis_Kelamin'] . '</td>
                                        <td>' . $row_buruh['Kategori_Keahlian'] . '</td>
                                        <td>
                                            <a href="#" class="tb-edit" data-id="' . $row_buruh['id_buruh'] . '"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="#" class="tb-hapus" data-id="' . $row_buruh['id_buruh'] . '"><i class="fa-solid fa-trash"></i></a>
                                        </td>
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

    <!-- Library js -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="Assets/JS/script.js"></script>

    <!-- ICONS -->
    <script>
        feather.replace();
    </script>
</body>

</html>