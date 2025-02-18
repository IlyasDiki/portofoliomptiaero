<?php
session_start();
require '../koneksi.php';

if (empty($_SESSION['adminID']) || $_SESSION['adminID'] == '') {
    header("Location: index.php");
    die();
}
// Fungsi untuk mengkonfirmasi pemesanan tiket
function SelesaiPemesanan($tiketID)
{
    global $koneksi;
    $sql = "UPDATE tiket SET status = 'Selesai' WHERE tiketID = $tiketID";
    $result = $koneksi->query($sql);
    return $result;
}

// Jika parameter 'konfirmasi' diberikan di URL, konfirmasi pemesanan tiket
if (isset($_GET['selesai'])) {
    $tiketID = $_GET['selesai'];
    $result = SelesaiPemesanan($tiketID);
    if ($result) {
        header("Location: pesanan-dikonfirmasi.php");
        die();
    } else {
        echo "Error: " . $koneksi->connect_error;
    }
}

// QUERY DATABASE SESUAI DENGAN ID YANG DIGUNAKAN LOGIN OLEH ADMIN
$adminID = $_SESSION['adminID'];

// QUERY DATABASE UNTUK MENDAPATKAN USERNAME ADMIN
$sql_get_username = "SELECT username FROM admin WHERE adminID = '$adminID'";
$result_get_username = $koneksi->query($sql_get_username);

if ($result_get_username->num_rows > 0) {
    $row = $result_get_username->fetch_assoc();
    $username_admin = $row['username'];
} else {
    // Jika data admin tidak ditemukan, tangani sesuai kebutuhan
    $username_admin = "Username tidak ditemukan";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        include("sidebar.html");
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include("topbar.html");
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Pesanan Dikonfirmasi</h1>
                    <p class="mb-4">Jika pesanan sudah digunakan mohon untuk klik selesai</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pesanan Dikonfirmasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tiket ID</th>
                                            <th>User ID</th>
                                            <th>Bus ID</th>
                                            <th>Tanggal Pesan</th>
                                            <th>Nomor Kursi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Tiket ID</th>
                                            <th>User ID</th>
                                            <th>Bus ID</th>
                                            <th>Tanggal Pesan</th>
                                            <th>Nomor Kursi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    // Ambil data pemesanan tiket yang sudah dikonfirmasi dari database
                                    $sql_dikonfirmasi = "SELECT * FROM tiket WHERE status = 'Success'";
                                    $result_dikonfirmasi = $koneksi->query($sql_dikonfirmasi);
                                    $no = 1;
                                    if ($result_dikonfirmasi->num_rows > 0) {
                                        while ($row = $result_dikonfirmasi->fetch_assoc()) {
                                            echo '<tr>
                                                    <td>' . $no . '</td>
                                                    <td>' . $row["tiketID"] . '</td>
                                                    <td>' . $row["userID"] . '</td>
                                                    <td>' . $row["busID"] . '</td>
                                                    <td>' . $row["tglPesan"] . '</td>
                                                    <td>' . $row["noKursi"] . '</td>
                                                    <td>' . $row["status"] . '</td>
                                                    <td><a href="?selesai=' . $row["tiketID"] . '">Selesai</a></td>
                                                  </tr>';
                                                  $no++; // Increment nomor urut setiap kali loop berjalan
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>Tidak ada pemesanan yang sudah dikonfirmasi.</td></tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Aerowolf</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>