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
    <?php include 'assets/header.php'; ?>
    <!-- Header End -->

    <div class="container">

        <!-- Sidebar Start -->
        <?php include 'assets/sidebar.php'; ?>
        <!-- Sidebar End -->


        <!-- Container Start-->
        <section class="hero" id="home">
            <div class="report">
                <h2>Gaji Buruh</h2>
                <?php
                    include 'connect.php';
                    $sql_select_gaji = "SELECT * FROM tb_gaji";
                    $result_gaji = $conn->query($sql_select_gaji);

                    if ($result_gaji) {

                        echo '<div class="tabular--wrapper">
                                <div class="table-container">
                                    <button class="view">View all</button>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID Gaji</th>
                                                <th>Gaji Buruh Kasar</th>
                                                <th>Gaji Operator</th>
                                                <th>Tanggal Kerja</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                        while ($row_gaji = $result_gaji->fetch_assoc()) {
                            echo '<tr>
                                    <td>' . $row_gaji['Id_gaji'] . '</td>
                                    <td>' . $row_gaji['Gaji_buruh_kasar'] . '</td>
                                    <td>' . $row_gaji['Gaji_Operator'] . '</td>
                                    <td>' . $row_gaji['Tanggal_Kerja'] . '</td>
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
    <?php include 'assets/footer.php'; ?>
    <!-- Footer End-->


    <script src="Assets/JS/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- ICONS -->
    <script>
        feather.replace();
    </script>
    
</body>

</html>