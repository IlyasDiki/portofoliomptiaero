<?php
session_start();
require '../koneksi.php';

if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
  $nama = "nama"; // Ganti dengan nama pengguna yang sesuai dari database
} else {
  // Jika pengguna belum login, variabel nama_pengguna diisi dengan string kosong
  $nama = "";
  header('../index.php');
}

$userID = $_SESSION['userID'];
$sql_tiket_saya = "SELECT * FROM tiket JOIN bus ON tiket.busID = bus.busID JOIN rute ON bus.ruteID = rute.ruteID WHERE tiket.userID = '$userID'";
$result_tiket_saya = $koneksi->query($sql_tiket_saya);
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
            <?php if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])): ?>
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
          <?php else: ?>
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
          <li>Tiket Saya</li>
        </ol>
        <h2>Tiket Saya</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">
        <h2>Tiket mu</h2>
        

        <table class="table">
          <thead>
            <tr>
              <th>Rute</th>
              <th>Kelas</th>
              <th>Tanggal Berangkat</th>
              <th>Waktu Keberangkatan</th>
              <th>Nomor Kursi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <?php
          if ($result_tiket_saya->num_rows > 0) {
            while ($row = $result_tiket_saya->fetch_assoc()) {
              echo '<tr>
                    <td>' . $row["agen"] . '</td>
                    <td>' . $row["kelas"] . '</td>
                    <td>' . $row["tglBerangkat"] . '</td>
                    <td>' . $row["wktBerangkat"] . '</td>
                    <td>' . $row["noKursi"] . '</td>
                    <td>' . $row["status"] . '</td>';

              // Tambahkan kondisi untuk menampilkan aksi berdasarkan status tiket
              if ($row["status"] === "Success") {
                echo '<td><a href="cetaktiket.php?tiketID=' . $row["tiketID"] . '" target="_blank"">Cetak Tiket</a></td>';
              } else if ($row["status"] === "Selesai") {
                echo '<td>Selesai</td>';
              } else {
                echo '<td>Proses</td>';
              }
              echo '</tr>';
            }
            echo '</table>';
          } else {
            echo "Belum ada tiket yang dipesan.";
          }
          ?>
          <h5>Mohon ditunggu hingga status pesanan berubah (Pending->Success)</h5>
      </div>
    </section><!-- End About Section -->

    <section id="featured" class="featured">
      <div class="container">

      </div>
    </section><!-- End Featured Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
      <div class="container">



      </div>
    </section><!-- End Testimonials Section -->

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