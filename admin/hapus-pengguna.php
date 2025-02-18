<?php
session_start();
require '../koneksi.php';

if (empty($_SESSION['adminID']) || $_SESSION['adminID'] == '') {
    header("Location: index.php");
    die();
}

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];
    $sql_hapus_pengguna = "DELETE FROM user WHERE userID = '$userID'";
    if ($koneksi->query($sql_hapus_pengguna) === TRUE) {
        header("Location: data-user.php");
        die();
    } else {
        echo "Gagal menghapus data pengguna.";
    }
} else {
    header("Location: data-user.php");
    die();
}
?>