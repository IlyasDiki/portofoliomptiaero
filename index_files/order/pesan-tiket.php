<?php
session_start();
require '../koneksi.php';
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
  // Jika pengguna sudah login, ambil nama pengguna dari database dan simpan ke variabel $nama
  $userID = $_SESSION['userID'];
  $sql_get_username = "SELECT nama FROM user WHERE userID = '$userID'";
  $result_get_username = $koneksi->query($sql_get_username);

  if ($result_get_username->num_rows > 0) {
      $row = $result_get_username->fetch_assoc();
      $nama = $row['nama'];
  } else {
      // Jika data pengguna tidak ditemukan, set nama pengguna ke string kosong
      $nama = "";
  }
} else {
  // Jika pengguna belum login, arahkan ke halaman login
  header("Location: ../order/login.php");
  die();
}


$userID = $_SESSION['userID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $busID = $_POST['busID'];
  $noKursi = $_POST['noKursi'];
  // Periksa apakah kursi masih tersedia sebelum melakukan pemesanan
  $sql_check_seat = "SELECT jumlah_kursi FROM bus WHERE busID = $busID";
  $result_check_seat = $koneksi->query($sql_check_seat);

  // Lakukan query untuk mengambil data jumlah_kursi dari tabel bus
  $sql = "SELECT jumlah_kursi FROM bus WHERE busID = 'id_bus_yang_dipilih'";
  $result = $koneksi->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Ambil nomor kursi yang sudah dipesan untuk bus ini dari tabel tiket
    $sql_dipesan = "SELECT noKursi FROM tiket WHERE busID = " . $row["busID"];
    $result_dipesan = $koneksi->query($sql_dipesan);

    $kursi_dipesan = array();
    if ($result_dipesan->num_rows > 0) {
      while ($row_dipesan = $result_dipesan->fetch_assoc()) {
        $kursi_dipesan[] = $row_dipesan['noKursi'];
      }
    }
  } else {
    echo "Data bus tidak ditemukan.";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Bus Harapan Jaya</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/modal.css" rel="stylesheet">

    <!-- Pastikan Anda telah memasukkan library jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Tambahkan library Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <!-- Tambahkan library Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- =======================================================
  * Template Name: Eterna
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/eterna-free-multipurpose-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
    <div class="container d-flex justify-content-between align-items-center">

      <div class="logo">
        <h1><a href="../index.php"><img src="../assets/img/slide/logo.png" alt="" class="img-fluid">&nbsp Bus Harapan Jaya</a>
        </h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>
      <?php
            if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
              // Jika pengguna sudah login, tampilkan nama pengguna
              // Ambil data pengguna dari database berdasarkan userID
              $userID = $_SESSION['userID'];
              $sql_user = "SELECT * FROM user WHERE userID = '$userID'";
              $result_user = $koneksi->query($sql_user);

              if ($result_user->num_rows == 1) {
                $user_data = $result_user->fetch_assoc();
                $nama = $user_data['nama'];
              } else {
                // Jika terjadi masalah saat mengambil data pengguna, keluarkan pesan kesalahan
                $nama = "nama";
              }
            }
            ?>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="../about.php">About</a></li>
          <li><a href="pesan-tiket.php">Reservasi</a></li>
            <!-- Bagian untuk menampilkan tombol login atau nama pengguna dan dropdown menu -->
          <li>
          <?php if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) : ?>
            <div class="dropdown">
                <a type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $nama; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="tiket-saya.php">History</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </div>
        </li>
        <?php else : ?>
            <li> <a href="order/login.php">Login</a></li>
        <?php endif; ?>


        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.php">Home</a></li>
          <li>Pesan Tiket</li>
        </ol>
        <h2>Pesan Tiket</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">
        <h2>Silahkan Pilih Rute</h2>
        <!-- Form pencarian rute berdasarkan asal, tujuan, dan tanggal berangkat -->
        <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <label for="asal">Asal:</label>
          <select class="form-select" name="asal" required>
            <option value="">Pilih Asal</option>
            <?php
            // Query untuk mengambil data asal dari tabel rute
            $sql_asal = "SELECT DISTINCT asal FROM rute";
            $result_asal = $koneksi->query($sql_asal);

            // Loop untuk menampilkan data asal sebagai pilihan dalam select
            if ($result_asal->num_rows > 0) {
              while ($row_asal = $result_asal->fetch_assoc()) {
                echo '<option value="' . $row_asal['asal'] . '">' . $row_asal['asal'] . '</option>';
              }
            }
            ?>
          </select>

          <label for="tujuan">Tujuan:</label>
          <select class="form-select" name="tujuan" required>
            <option value="">Pilih Tujuan</option>
            <?php
            // Query untuk mengambil data tujuan dari tabel rute
            $sql_tujuan = "SELECT DISTINCT tujuan FROM rute";
            $result_tujuan = $koneksi->query($sql_tujuan);

            // Loop untuk menampilkan data tujuan sebagai pilihan dalam select
            if ($result_tujuan->num_rows > 0) {
              while ($row_tujuan = $result_tujuan->fetch_assoc()) {
                echo '<option value="' . $row_tujuan['tujuan'] . '">' . $row_tujuan['tujuan'] . '</option>';
              }
            }
            ?>
          </select>
          <label for="tgl_berangkat">Tanggal Berangkat:</label>
          <input class="form-select" type="date" name="tgl_berangkat" required>
          <input class="btn btn-danger" type="submit" name="submit_search" value="Cari Rute">
          </form>
          <?php
          // Cek apakah form pencarian disubmit
          if (isset($_GET['submit_search'])) {
            $asal = $_GET['asal'];
            $tujuan = $_GET['tujuan'];
            $tgl_berangkat = $_GET['tgl_berangkat'];

            // Lakukan pencarian berdasarkan asal, tujuan, dan tanggal berangkat
            $sql_search_rute = "SELECT * FROM bus 
                                JOIN rute ON rute.ruteID = bus.ruteID 
                                WHERE rute.asal = '$asal' AND rute.tujuan = '$tujuan' AND bus.tglBerangkat = '$tgl_berangkat' 
                                ORDER BY tglBerangkat ASC, wktBerangkat ASC";
            $result_search_rute = $koneksi->query($sql_search_rute);
            ?>
          <?php
          if ($result_search_rute->num_rows > 0) {
              while ($row = $result_search_rute->fetch_assoc()) {
                echo '<div class="jadwal"></div>
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">RUTE</th>
                          <th scope="col">TANGGAL BERANGKAT</th>
                          <th scope="col">JAM</th>
                          <th scope="col">KURSI TERSISA</th>
                          <th scope="col">HARGA</th>
                          <th scope="col">NO KURSI</th>
                          <th scope="col">Aksi</th>
                        </tr>
                      </thead>      
                      <tbody>
                        <tr>
                          <td>' . $row["agen"] . '</td>
                          <td>' . $row["tglBerangkat"] . '</td>
                          <td>' . $row["wktBerangkat"] . '</td>
                          <td>' . $row["jumlah_kursi"] . '</td>
                          <td>' . $row["harga"] . '</td>
                          <td>
                    ';
                // Ambil nomor kursi yang sudah dipesan untuk bus ini dari tabel tiket
                $sql_dipesan = "SELECT noKursi FROM tiket WHERE busID = " . $row["busID"];
                $result_dipesan = $koneksi->query($sql_dipesan);

                $kursi_dipesan = array();
                if ($result_dipesan->num_rows > 0) {
                  while ($row_dipesan = $result_dipesan->fetch_assoc()) {
                    $kursi_dipesan[] = $row_dipesan['noKursi'];
                  }
                }

                echo '<form method="post" action="order.php">
                            <input type="hidden" name="busID" value="' . $row["busID"] . '">
                            <select class="form-select" name="noKursi" required>
                                <option value="">Pilih Nomor Kursi</option>';

                $jmlkursi = $row["jumlah_kursi"]; // Ganti dengan jumlah kursi yang sesuai dengan bus Anda
                for ($i = 1; $i <= $jmlkursi; $i++) {
                  if (!in_array($i, $kursi_dipesan)) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                  }
                }
                echo'</td> ';
                echo '</select>';
                 // Cek apakah jumlah kursi tersedia adalah 0
                      if ($jmlkursi == 0) {
                        echo '<td><input type="submit" class="btn btn-danger" value="HABIS" Disabled>';
                    } else {
                        echo '<td><input type="submit" class="btn btn-danger" value="Pesan Tiket">';
                    }

          
                        echo '</form></td>
                        </tr>
                        </tbody>
                    </div>
                    ';   
              }
                 echo '</table>';

            } else {
              echo "Tidak ada jadwal bis tersedia sesuai pencarian.";
            }
          }
          ?>
          </div>
      </div>
    </section><!-- End About Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <p>PT. Harapan Jaya Prima
              Alamat : Jalan Harapan Jaya
              No Tlp : Nomor Harapan Jaya
              Email : Email Harpan Jaya
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>Contact Us</h4>
            <p>
              A108 Adam Street <br>
              New York, NY 535022<br>
              United States <br><br>
              <strong>Phone:</strong> +1 5589 55488 55<br>
              <strong>Email:</strong> info@example.com<br>
            </p>

          </div>

          <div class="col-lg-3 col-md-6 footer-info">
            <h3>About Eterna</h3>
            <p>PT. Harapan Jaya Prima
              Alamat : Jalan Harapan Jaya
              No Tlp : Nomor Harapan Jaya
              Email : Email Harpan Jaya
            </p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Bus harapan Jaya</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/eterna-free-multipurpose-bootstrap-template/ -->

      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>