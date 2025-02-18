<?php
session_start();
require '../koneksi.php';

if (empty($_SESSION['adminID']) || $_SESSION['adminID'] == '') {
    header("Location: index.php");
}
// Fungsi untuk mendapatkan angka terakhir dari ruteID
function getLastIdRute()
{
    global $koneksi;
    $sql = "SELECT last_ruteID FROM rute_counter";
    $result = $koneksi->query($sql);
    $row = $result->fetch_assoc();
    return $row['last_ruteID'];
}

// Fungsi untuk menyimpan angka terakhir dari ruteID
function saveLastIdRute($lastId)
{
    global $koneksi;
    $sql = "UPDATE rute_counter SET last_ruteID = $lastId";
    $koneksi->query($sql);
}

// Fungsi untuk menambah jadwal baru
function tambahJadwal($tglBerangkat, $asal, $tujuan, $wktBerangkat, $jumlah_kursi)
{
    global $koneksi;

     // Dapatkan angka terakhir dari ruteID
     $lastId = getLastIdRute();

     // Tingkatkan nilai angka terakhir dengan 1 untuk mendapatkan ruteID baru
     $ruteID = $lastId + 1;
 
    // Insert data ke tabel "rute"
    $sql_rute = "INSERT INTO rute (ruteID,asal,tujuan) VALUES ('$asal', '$tujuan')";
    $result_rute = $koneksi->query($sql_rute);

    if ($result_rute) {
        // Ambil ruteID yang baru saja dimasukkan
        $ruteID = $koneksi->insert_id;

        // Insert data ke tabel "bus" dengan menggunakan ruteID
        $sql_bus = "INSERT INTO bus (tglBerangkat, ruteID, wktBerangkat, jumlah_kursi) 
                    VALUES ('$tglBerangkat', $ruteID, '$wktBerangkat', $jumlah_kursi)";
        $result_bus = $koneksi->query($sql_bus);

        return $result_bus;
    } else {
        return false;
    }
}

// Jika form tambah jadwal disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_tambah_jadwal'])) {
    $tglBerangkat = $_POST['tglBerangkat'];
    $asal = $_POST['asal'];
    $tujuan = $_POST['tujuan'];
    $wktBerangkat = $_POST['wktBerangkat'];
    $jumlah_kursi = $_POST['jumlah_kursi'];

    $result = tambahJadwal($tglBerangkat, $asal, $tujuan, $wktBerangkat, $jumlah_kursi);
    if ($result) {
        header("Location: lihat-jadwal.php");
        die();
    } else {
        echo "Error: " . $koneksi->connect_error;
    }
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
                    <h1 class="h3 mb-2 text-gray-800">Tambah Jadwal Baru</h1>
                   
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <label for="tglBerangkat">Tanggal Berangkat:</label>
                            <input class="form-control" type="date" name="tglBerangkat" required>
                            <br>
                            <label for="asal">Asal:</label>
                            <input class="form-control" type="text" name="asal" required>
                            <br>
                            <label for="tujuan">Tujuan:</label>
                            <input class="form-control" type="text" name="tujuan" required>
                            <br>
                            <label for="wktBerangkat">Waktu Berangkat:</label>
                            <input class="form-control" type="time" name="wktBerangkat" required>
                            <br>
                            <label for="jumlah_kursi">Jumlah Kursi:</label>
                            <input class="form-control" type="number" name="jumlah_kursi" required>
                            <br>
                            <input class="btn btn-primary" type="submit" name="submit_tambah_jadwal" value="Tambah Jadwal">
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