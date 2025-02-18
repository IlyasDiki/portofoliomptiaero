<?php
session_start();
require '../koneksi.php';

if (empty($_SESSION['adminID']) || $_SESSION['adminID'] == '') {
    header("Location: index.php");
    die();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    die();
}

$adminID = $_SESSION['adminID'];
// QUERY DATABASE YANG DIPERLUKAN

// QUERY DATABASE SESUAI DENGAN ID YANG DIGUNAKAN LOGIN OLEH ADMIN

// END OF QUERY DATABASE YANG DIPERLUKAN

// PROSES UNTUK MENGHITUNG DATA TAMPILAN DASHBOARD
$jumlah_pesanan_tertunda = 0;
$jumlah_pesanan_selesai = 0;
$total_uang_pesanan_tertunda = 0;
$total_uang_pesanan_selesai = 0;

// Query untuk mendapatkan jumlah pesanan tertunda
$sql_tertunda = "SELECT COUNT(*) AS jumlah_tertunda FROM tiket WHERE status = 'Pending'";
$result_tertunda = $koneksi->query($sql_tertunda);
$jumlah_pesanan_tertunda = $result_tertunda->fetch_assoc()['jumlah_tertunda'];

// Query untuk mendapatkan jumlah pesanan ditolak
$sql_ditolak = "SELECT COUNT(*) AS jumlah_ditolak FROM tiket WHERE status = 'Ditolak'";
$result_ditolak = $koneksi->query($sql_ditolak);
$jumlah_pesanan_ditolak = $result_ditolak->fetch_assoc()['jumlah_ditolak'];

// Query untuk mendapatkan jumlah pesanan selesai
$sql_selesai = "SELECT COUNT(*) AS jumlah_selesai FROM tiket WHERE status = 'Selesai'";
$result_selesai = $koneksi->query($sql_selesai);
$jumlah_pesanan_selesai = $result_selesai->fetch_assoc()['jumlah_selesai'];

function hitungTotalPendapatanTertunda()
{
    global $koneksi;

    $sql = "SELECT COUNT(*) AS jumlah_tertunda FROM tiket WHERE status = 'Pending'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $jumlah_tertunda = $row["jumlah_tertunda"];

        // Ambil harga tiket dari tabel bus
        $sql_harga = "SELECT harga FROM bus LIMIT 1";
        $result_harga = $koneksi->query($sql_harga);

        if ($result_harga->num_rows > 0) {
            $row_harga = $result_harga->fetch_assoc();
            $harga_tiket = $row_harga["harga"];

            // Hitung total pendapatan tertunda berdasarkan jumlah tiket dan harga tiket
            $total_pendapatan_tertunda = $jumlah_tertunda * $harga_tiket;
            return $total_pendapatan_tertunda;
        }
    }

    return 0; // Jika tidak ada tiket tertunda, kembalikan nilai 0
}

// Fungsi untuk menghitung jumlah pendapatan dari pesanan selesai
function hitungTotalPendapatanSelesai()
{
    global $koneksi;

    $sql = "SELECT COUNT(*) AS jumlah_selesai FROM tiket WHERE status = 'Selesai'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $jumlah_selesai = $row["jumlah_selesai"];

        // Ambil harga tiket dari tabel bus
        $sql_harga = "SELECT harga FROM bus LIMIT 1";
        $result_harga = $koneksi->query($sql_harga);

        if ($result_harga->num_rows > 0) {
            $row_harga = $result_harga->fetch_assoc();
            $harga_tiket = $row_harga["harga"];

            // Hitung total pendapatan tertunda berdasarkan jumlah tiket dan harga tiket
            $total_pendapatan_selesai = $jumlah_selesai * $harga_tiket;
            return $total_pendapatan_selesai;
        }
    }

    return 0; // Jika tidak ada tiket tertunda, kembalikan nilai 0
}

// END OF PROSES UNTUK MENGHITUNG DATA TAMPILAN DASHBOARD

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

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Side bar-->
        <?php
        include("sidebar.html");
        ?>
        <!-- End of side bar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- DASHBOARD -->
            <div id="content">

                <!-- Top bar -->
                <?php
                include("topbar.html")
                ?>
                <!-- End of top bar -->
                
                <div class="container-fluid">

                <!-- TAMPILAN DASHBOARD -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- COLUMN 1 -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Penghasilan (Selesai)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP. <?php echo hitungTotalPendapatanSelesai(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-signr fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COLUMN 2 -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Penghasilan (Tertunda)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP.<?php echo hitungTotalPendapatanTertunda(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- COLUMN 3 -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            
                                            <div class="row no-gutters align-items-center">
                                                
                                            <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Pesanan Selesai</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_pesanan_selesai?></div>
                                        </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COLUMN 4 -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pesanan Tertunda</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_pesanan_tertunda ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                

            </div>
            <!-- END OF DASHBOARD -->

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

    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>