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
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
          <li><a href="index.php">Home</a></li>
          <li><a class="active" href="about.php">About</a></li>
          <li><a href="order/pesan-tiket.php">Reservasi</a></li>
            <!-- Bagian untuk menampilkan tombol login atau nama pengguna dan dropdown menu -->
          <li>
          <?php if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) : ?>
            <div class="dropdown">
                <a type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $nama; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="order2/tiket-saya.php">History</a>
                    <a class="dropdown-item" href="order2/logout.php">Logout</a>
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
          <li>About Us</li>
        </ol>
        <h2>About Us</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row">
          <div class="col-lg-6">
            <img src="assets/img/busabout.png" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 content">
            <h3>Bus Harapan Jaya</h3>
            <p class="fst-italic">
              PT. Harapan Jaya Prima berdiri sejak tahun 1977 oleh Almarhum Harjaya Cahyana. Armada yang pertama kali beroperasi sebanyak 3 unit dengan trayek Tulungagung – Kediri – Surabaya – PP. Pada tahun 1993, PT. Harapan Jaya Prima kembali membuka rute baru dengan trayek Tulung Agung – Jakarta PP
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> Mudah</li>
              <li><i class="bi bi-check-circle"></i> Aman</li>
              <li><i class="bi bi-check-circle"></i> Terpercaya</li>
            </ul>
            
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <section id="featured" class="featured">
      <div class="container">

        <div class="row justify-content-center">
          <div class="col-lg-4 mt-4 mt-lg-0 mb-4">
            <div class="icon-box">
              <i class="bi bi-bus-front"></i>
              <h3><a href="">Visi</a></h3>
              <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
            </div>
          </div>
          <div class="col-lg-4 mt-4 mt-lg-0 mb-4">
            <div class="icon-box">
              <i class="bi bi-bus-front-fill"></i>
              <h3><a href="">Misi</a></h3>
              <p>Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p>
            </div>
          </div>
          
        </div>

      </div>
    </section><!-- End Featured Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
      <div class="container">

        <div class="section-title">
          <h2>Testimonials</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
              <h3>Andika Putra Maulana</h3>
              <h4>Ceo &amp; Founder</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                bisn ya ok bangettt, baru baru.. bersih dan pelayanan supirnya juga ramah dan sopan. harga bersaing dan fasilitas ok.. pokoknya gak nyesel deh pake bus ini OK BANGET👍👍👍
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="testimonial-item mt-4 mt-lg-0">
              <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
              <h3>Erisa Clara Aulia</h3>
              <h4>Designer</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Bus nya bagus, bersih, crew ramah, dan tau jalan jadi kita pikniknya happy... Sukses terus dan semoga tambah banyak unitnya karna sering ga kebagian... Hehehe
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="testimonial-item mt-4">
              <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
              <h3>Asdiansyah Ferli</h3>
              <h4>Store Owner</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Bus nya nyaman... Supir mantap pengalaman banget.. ramah n klop pokoknya... sya pake ke Citra Alam... Sya hilang kontak dengan beliau... semoga Esok pake Bus ini berjumpa lg... pokok nya
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="testimonial-item mt-4">
              <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
              <h3>Muhammad Daffa Rizki</h3>
              <h4>Freelancer</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Perjalanan lancar, pengemudi dan kernet nya baik, bersih, dan ramah..ada sdikit problem di kelistrikan sih, tp cepet lgsng ditangani... harga terbaik dari yang baik di kelasnya... Besok2 akan dipromosiin deh.. :) Thanks ya...semoga mkin baik ke depannya...
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="testimonial-item mt-4">
              <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
              <h3>Yunanda Sasi Maulida</h3>
              <h4>Entrepreneur</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Salah satu perusahaan jasa transportasi yg bagus,berkelas,aman, nyaman dalam pelayanan, mengutamakan pelayanan, armada nya terawat dengan ter skejul, crew nya ramah "pelayanan kantornya bagus dan kantornya bagus sekali, cepat tanggap dalam menghadapi complain, pokok nya puas deh....
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="testimonial-item mt-4">
              <img src="assets/img/testimonials/testimonials-6.jpg" class="testimonial-img" alt="">
              <h3>Galuh Dwi Anjani</h3>
              <h4>Store Owner</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Tempat Sewa Bus Pariwisata Terbaik di Bekasi, Armada Bus nya bagus – bagus dan terawat, fasilitas bus juga lengkap dan harga sewa nya menurut saya sangat terjangkau, customer service sangat ramah, pool bus luas dan rapih, sangat recommended deh…
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

        </div>

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
              No Tlp   : Nomor Harapan Jaya
              Email    : Email Harpan Jaya
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
              No Tlp   : Nomor Harapan Jaya
              Email    : Email Harpan Jaya
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

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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