<?php
// Memulai sesi
session_start();
require 'koneksi.php';
// Mengecek apakah pengguna sudah login
if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
  $nama = "nama"; // Ganti dengan nama pengguna yang sesuai dari database
} else {
  // Jika pengguna belum login, variabel nama_pengguna diisi dengan string kosong
  $nama = "";
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
  <link href="assets/img/slide/logo.png" rel="icon">
  <link href="assets/img/slide/logo.png" rel="apple-touch-icon">


  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/modal.css" rel="stylesheet">

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
          <li>

          </li>
          <li><a class="active" href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="order/pesan-tiket.php">Reservasi</a></li>
            <!-- Bagian untuk menampilkan tombol login atau nama pengguna dan dropdown menu -->
          <li>
          <?php if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) : ?>
            <div class="dropdown">
                <a type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $nama; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="order/tiket-saya.php">History</a>
                    <a class="dropdown-item" href="order/logout.php">Logout</a>
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

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container">
      <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

        <div class="carousel-inner" role="listbox">
          <!-- Slide 1 -->
          <div class="carousel-item active" style="background-image: url(assets/img/slide/bushj-01.png)">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">Keselamatan dan kenyamanan <br><span> anda </span>
                  <br> tujuan utama <br><span>kami</span> </h2>

              </div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="carousel-item" style="background-image: url(assets/img/slide/busslide2.webp)">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated fanimate__adeInDown">Bus Harapan Jaya<span> KarangJati</span></h2>
                <p class="animate__animated animate__fadeInUp">Selamat datang di Web PT. Harapan Jaya Agen Karangjati
                  ,Disini anda dapat temukan segala informasi tentang layanan jasa tranportasi Bus PT. Harapan Jaya
                  Karangjati.</p>
                <a href="services.php" class="btn-get-started animate__animated animate__fadeInUp">Reservasi
                  Sekarang</a>
              </div>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="carousel-item" style="background-image: url(assets/img/slide/busslide4.webp)">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">Pesan Tiket Lebih <span>Aman</span></h2>
                <p class="animate__animated animate__fadeInUp">Tiket anda akan diproses dengan cepat tanpa ada kendala
                </p>
                <a href="" class="btn-get-started animate__animated animate__fadeInUp">Reservasi Sekarang</a>
              </div>
            </div>
          </div>

        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

      </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Featured Section ======= -->
    <section id="featured" class="featured">
      <div class="container">

        <div class="row justify-content-center">
          <div class="col-lg-4 mt-4 mt-lg-0 mb-4">
            <div class="icon-box">
              <i class="bi bi-bus-front"></i>
              <h3><a href="">Efektif dan efisien </a></h3>
              <p>Bahwa setiap tindakan harus selalu memperhitunghkan asas efektif dan efisien. Efektif bahwa hasilnya
                haruslah tepat sasaran (optimal) sedangkan Efisien artinya bahwa dalam pemakain biaya dan sumber daya
                harus hemat atau tidak boros.</p>
            </div>
          </div>
          <div class="col-lg-4 mt-4 mt-lg-0 mb-4">
            <div class="icon-box">
              <i class="bi bi-bus-front-fill"></i>
              <h3><a href="">Nyaman</a></h3>
              <p>Nyaman terwujud ketenangan dan kenikmatan bagi penumpang karena fasilitas dan perawatan serta
                pengoprasian armada yang aman.</p>
            </div>
          </div>
          <div class="col-lg-4 mt-4 mt-lg-0 mb-4">
            <div class="icon-box">
              <i class="bi bi-bus-front"></i>
              <h3><a href="">Jaminan </a></h3>
              <p>Jaminan artinya bahwa setiap layanan operasional yang diberikan mempunyai garansi serta standar
                kualitas mutu yang dipertangungjawabkan</p>
            </div>
          </div>
          <div class="col-lg-4 mt-4 mt-lg-0 mb-4">
            <div class="icon-box">
              <i class="bi bi-bus-front-fill"></i>
              <h3><a href="">Objektif</a></h3>
              <p>Objektif artinya dalam memandang dan menyelesaikan suatu permasalahan harusla benar-benar dicermati
                sumbernya dan adil, yang benar dikatan dan yang salah dikatakan salah</p>
            </div>
          </div>
          <div class="col-lg-4 mt-4 mt-lg-0 mb-4">
            <div class="icon-box">
              <i class="bi bi-bus-front"></i>
              <h3><a href="">Yakin</a></h3>
              <p>Yakin artinya sungguh-sungguh, pasti dan tegas. Yakin secara spiritual bermakna bahwa semua karyawan
                harus berlandaskan Ketuhanan yang maha esa.</p>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Featured Section -->





  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">


    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>PT. Harapan Jaya Prima </h4>
            <p>Agen Karangjati Jl. Raya Ngawi - Caruban, Dusun Bangon, Karangjati,
              Kec. Karangjati, Kabupaten Ngawi, Jawa Timur
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Beranda</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Fasilitas</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Tentang</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Service</a></li>


            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>Contact Us</h4>
            <p>
              Jl. Raya Ngawi - Caruban, <br>
              Dusun Bangon, Karangjati, Kec. Karangjati,<br>
              Kabupaten Ngawi, Jawa Timur <br><br>
              <strong>Phone:</strong> 0821-1104-2139<br>
              <strong>Email:</strong> harapanjayakarangjati@gmail.com<br>
            </p>

          </div>

          <div class="col-lg-3 col-md-6 footer-info">

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
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>