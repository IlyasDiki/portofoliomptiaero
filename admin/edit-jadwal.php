<?php
session_start();
require '../koneksi.php';

if (empty($_SESSION['adminID']) || $_SESSION['adminID'] == '') {
    header("Location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $busID = $_POST['busID'];
    $tglBerangkat = $_POST['tglBerangkat'];
    $wktBerangkat = $_POST['wktBerangkat'];
    $jumlah_kursi = $_POST['jumlah_kursi'];

    $sql_update_jadwal = "UPDATE bus SET tglBerangkat = '$tglBerangkat', wktBerangkat = '$wktBerangkat', jumlah_kursi = '$jumlah_kursi' WHERE busID = $busID";
    if ($koneksi->query($sql_update_jadwal) === TRUE) {
        header("Location: lihat-jadwal.php");
        die();
    } else {
        echo "Gagal mengupdate jadwal tiket.";
    }
}

if (isset($_GET['busID'])) {
    $busID = $_GET['busID'];
    $sql_jadwal = "SELECT * FROM bus WHERE busID = $busID";
    $result_jadwal = $koneksi->query($sql_jadwal);

    if ($result_jadwal->num_rows == 1) {
        $row = $result_jadwal->fetch_assoc();
    } else {
        header("Location: lihat-jadwal.php");
        die();
    }
} else {
    header("Location: lihat-jadwal.php");
    die();
}

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
                    <h1 class="h3 mb-2 text-gray-800">Edit Jadwal Tiket</h1>
                    <!-- DataTales Example -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="busID" value="<?php echo $busID; ?>">
                        <label for="tglBerangkat">Tanggal Berangkat:</label>
                        <input class="form-control" type="date" name="tglBerangkat" value="<?php echo $row['tglBerangkat']; ?>" required>
                        <br>
                        <label for="wktBerangkat">Waktu Keberangkatan:</label>
                        <input class="form-control" type="time" name="wktBerangkat" value="<?php echo $row['wktBerangkat']; ?>" required>
                        <br>
                        <label for="jumlah_kursi">Jumlah Kursi:</label>
                        <input class="form-control" type="number" name="jumlah_kursi" min="1" value="<?php echo $row['jumlah_kursi']; ?>" required>
                        <br>
                        <input class="btn btn-primary" type="submit" value="Simpan">
                    </form>
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