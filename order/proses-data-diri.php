<?php
session_start();
require '../koneksi.php';

if (empty($_SESSION['userID']) || $_SESSION['userID'] == '') {
    header("Location: ../order/index.php");
    die();
}

// Proses penyimpanan data diri dan pesan tiket
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_data_diri'])) {
    // Ambil data dari form data-diri.php
    $userID = $_POST['userID'];
    $busID = $_POST['busID'];
    $noKursi = $_POST['noKursi'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    // Proses upload bukti pembayaran
    $targetDir = "uploads/"; // Folder untuk menyimpan file foto
    $bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];
    $targetFile = $targetDir . basename($bukti_pembayaran);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Cek apakah file foto adalah file gambar valid
    if ($bukti_pembayaran != "") {
        $check = getimagesize($_FILES['bukti_pembayaran']['tmp_name']);
        if ($check !== false) {
            echo "File adalah gambar - " . $check['mime'] . ".";
            $uploadOk = 1;
        } else {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }
    }

    // Cek apakah file sudah ada atau belum
    if (file_exists($targetFile)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($_FILES['bukti_pembayaran']['size'] > 500000) {
        echo "Maaf, ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Cek format file yang diizinkan
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Jika tidak ada masalah dengan upload, simpan data diri dan bukti pembayaran ke dalam database
    if ($uploadOk == 1) {
        // Proses penyimpanan data diri ke dalam tabel data_diri
        $sql_insert_data_diri = "INSERT INTO data_diri (userID, nama, alamat, telepon) VALUES ('$userID', '$nama', '$alamat', '$telepon')";
        if ($koneksi->query($sql_insert_data_diri) === TRUE) {
            // Proses penyimpanan informasi pembayaran ke dalam tabel bukti_pembayaran
            $sql_insert_bukti_pembayaran = "INSERT INTO bukti_pembayaran (userID, busID, noKursi, bukti_file) 
                                            VALUES ('$userID', '$busID', '$noKursi', '$bukti_pembayaran')";
            if ($koneksi->query($sql_insert_bukti_pembayaran) === TRUE) {
                // Tampilkan notifikasi berhasil pesan tiket dan tunggu konfirmasi dari admin
                echo "<script>alert('Berhasil melakukan pemesanan tiket. Mohon untuk menunggu konfirmasi dari admin.');</script>";
                header('Location: tiket-saya.php'); // Redirect ke halaman tiket-saya.php
                exit(); // Berhenti agar kode di bawahnya tidak dijalankan
            } else {
                echo "Maaf, terjadi kesalahan saat menyimpan informasi pembayaran.";
            }
        } else {
            echo "Maaf, terjadi kesalahan saat menyimpan data diri.";
        }
    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah file bukti pembayaran.";
    }
}
?>