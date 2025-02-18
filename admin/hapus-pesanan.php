<?php
session_start();
require '../koneksi.php';

if (empty($_SESSION['adminID']) || $_SESSION['adminID'] == '') {
    header("Location: index.php");
    die();
}

if (isset($_GET['tiketID'])) {
    $tiketID = $_GET['tiketID'];
    $sql_hapus_pengguna = "DELETE FROM tiket WHERE tiketID = '$tiketID'";
    if ($koneksi->query($sql_hapus_pengguna) === TRUE) {
        header("Location: pesanan-selesai.php");
        die();
    } else {
        echo "Gagal menghapus data pengguna.";
    }
} else {
    header("Location: pesanan-selesai.php");
    die();
}
?>