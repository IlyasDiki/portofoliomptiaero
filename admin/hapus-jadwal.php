<?php
session_start();
require '../koneksi.php';

if (empty($_SESSION['adminID']) || $_SESSION['adminID'] == '') {
    header("Location: index.php");
    die();
}

if (isset($_GET['busID'])) {
    $busID = $_GET['busID'];


    // Mulai transaksi
    $koneksi->begin_transaction();

    try {
        // Hapus data tiket berdasarkan busID dan ruteID

        // Hapus data bus berdasarkan busID
        $sql_hapus_bus = "DELETE FROM bus WHERE busID = $busID";
        $koneksi->query($sql_hapus_bus);


        // Commit transaksi jika tidak ada masalah
        $koneksi->commit();

        echo "Data bus  berhasil dihapus.";
        header("Location: lihat-jadwal.php");
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        $koneksi->rollback();
        echo "Terjadi kesalahan dalam menghapus data: Ada data yang tersambung dengan user " . $e->getMessage();
    }
} else {
    echo "Data busID  tidak ditemukan.";
}
?>