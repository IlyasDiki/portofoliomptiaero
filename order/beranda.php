<?php
session_start();

if (empty($_SESSION['userID'])) {
    header("Location: ../order/login.php");
    die();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Beranda</title>
    <!-- Tambahkan tag HTML untuk link CSS atau gaya tampilan jika diperlukan -->
</head>

<body>
    <h2>Selamat datang, Pengguna!</h2>
    <p><a href="pesan-tiket.php">Pesan Tiket</a></p>
    <p><a href="tiket-saya.php">Lihat Tiket Saya</a></p>
</body>

</html>