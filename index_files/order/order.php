<?php
session_start();
require '../koneksi.php';

if (empty($_SESSION['userID']) || $_SESSION['userID'] == '') {
  header('../order/index.php');
}

$userID = $_SESSION['userID'];

// Periksa apakah parameter sudah diterima dari halaman tiket.php
if (isset($_POST['busID']) && isset($_POST['noKursi'])) {
  $busID = $_POST['busID'];
  $noKursi = $_POST['noKursi'];
} else {
  // Jika parameter tidak lengkap, kembali ke halaman tiket.php
  echo 'alert("Data Tidak Lengkap")';
  exit;
}

$sql_get_harga = "SELECT harga FROM bus WHERE busID = '$busID'";
$result_get_harga = $koneksi->query($sql_get_harga);

if ($result_get_harga->num_rows > 0) {
    $row = $result_get_harga->fetch_assoc();
    $harga = $row['harga'];
} else {
    $harga = "Harga tidak ditemukan"; // Atau tangani sesuai kebutuhan jika harga tidak ditemukan
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
        <h1><a href="index.php"><img src="assets/img/slide/logo.png" alt="" class="img-fluid">&nbsp Bus Harapan Jaya</a>
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
          <li><a href="order.php">Reservasi</a></li>
          <li>Pesan Tiket</li>
        </ol>
        <h2>Pesan Tiket</h2>
      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= About Section ======= -->
    <section id="home" class="home">
      <div class="container">
        <h2>Lanjut Info Pembayaran</h2>
        <p><img src="../assets/img/bni.jpg" width="60px" height="30px">Bank Tujuan VA BNI : 0832 2542 4533 4242</p>
        <p><img src="../assets/img/bca.png" width="60px" height="20px">Bank Tujuan VA BCA : 0832 2542 4533 4242</p>
        <p><img src="../assets/img/bri.jpg" width="60px" height="30px">Bank Tujuan VA BRI : 0832 2542 4533 4242</p>
        <p>Total Pembayaran: <b><?php echo $harga; ?></b></p>
        <!-- Buat form untuk mengisi data diri -->
        <form method="post" action="proses-pesan.php" enctype="multipart/form-data">
          <!-- Sisipkan input dengan tipe hidden untuk menyimpan data yang diambil dari halaman tiket.php -->
          <input type="hidden" name="userID" value="<?php echo $userID; ?>">
          <input type="hidden" name="busID" value="<?php echo $busID; ?>">
          <input type="hidden" name="noKursi" value="<?php echo $noKursi; ?>">
          <!-- Tambahkan input untuk mengisi data diri lainnya -->
          <div class="mb-3">
            <label class="form-label" for="email">Nama:</label>
            <input class="form-control" type="textarea" name="nama" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="email">Alamat:</label>
            <input class="form-control" type="alamat" name="alamat" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="email">Telepon:</label>
            <input class="form-control" type="number" name="telepon" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="email">Bukti Pembayaran:</label>
            <input class="form-control" type="file" name="buktiPembayaran" accept=".png, .jpg, .jpeg" required>
          </div>

         <input type="hidden" name="tglPesan" value="<?php echo date('Y-m-d'); ?>">
          <!-- Tambahkan input lainnya sesuai kebutuhan -->
          <input class="btn btn-danger" type="submit" name="submit" value="Pesan Tiket">
        </form>

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
  <script>
  // Tambahkan kode JavaScript untuk menampilkan alert setelah pengiriman formulir
  window.onload = function() {
      const form = document.querySelector('form');
      form.onsubmit = function() {
          // Simulasi hasil pemesanan (gantikan dengan kode pemrosesan sesungguhnya)
          const berhasil = true; // Ganti dengan nilai false jika pemesanan gagal

          if (berhasil) {
              // Tampilkan alert jika berhasil
              alert("Pesanan telah berhasil dilakukan!");
              return true;
          } else {
              // Tampilkan alert jika gagal
              alert("Pesanan gagal. Silakan coba lagi.");
              return false; // Form tidak akan dikirim jika pemesanan gagal
          }
      };
  };
  </script>
</body>
</html>