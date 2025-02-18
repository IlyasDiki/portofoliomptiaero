<?php
session_start();
require '../koneksi.php';

if (empty($_SESSION['userID']) || $_SESSION['userID'] == '') {
    header('../order/index.php');
}
// proses_pesan.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $userID = $_POST['userID'];
    $busID = $_POST['busID'];
    $noKursi = $_POST['noKursi'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $tglPesan = $_POST['tglPesan'];

    // Lakukan operasi untuk menyimpan data ke tabel tiket, misalnya menggunakan koneksi ke database
    // Query INSERT untuk menyimpan data ke tabel tiket
    $sql = "INSERT INTO tiket (userID, busID, noKursi, nama, alamat, telepon, tglPesan) VALUES ('$userID', '$busID', '$noKursi', '$nama', '$alamat', '$telepon', '$tglPesan')";

    // Eksekusi query (pastikan Anda sudah membuat koneksi ke database sebelumnya)
    $sql_check_seat = "SELECT jumlah_kursi FROM bus WHERE busID = $busID";
    $result_check_seat = $koneksi->query($sql_check_seat);

    if ($result_check_seat->num_rows > 0) {
        $row = $result_check_seat->fetch_assoc();
        if ($row['jumlah_kursi'] > 0) {
            // Lakukan pemesanan
            if ($koneksi->query($sql) === TRUE) {
                // Kurangi jumlah kursi yang tersedia
                $sql_update_seat = "UPDATE bus SET jumlah_kursi = jumlah_kursi - 1 WHERE busID = $busID";
                $koneksi->query($sql_update_seat);
                // Proses upload bukti pembayaran
                if (isset($_FILES['buktiPembayaran']) && $_FILES['buktiPembayaran']['error'] === UPLOAD_ERR_OK) {
                    $file_tmp = $_FILES['buktiPembayaran']['tmp_name'];
                    $file_name = $_FILES['buktiPembayaran']['name'];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                    // Pastikan file yang diunggah adalah gambar PNG atau JPG/JPEG
                    if ($file_ext === 'png' || $file_ext === 'jpg' || $file_ext === 'jpeg') {
                        $target_dir = "uploads/"; // Ganti dengan direktori yang sesuai
                        $target_file = $target_dir . basename($file_name);

                        if (move_uploaded_file($file_tmp, $target_file)) {
                            // Proses penyimpanan informasi bukti pembayaran ke database, misalnya dengan mengupdate kolom "buktiPembayaran" di tabel tiket
                            $sql_insert_bukti = "UPDATE tiket SET buktiPembayaran = '$target_file' WHERE tiketID = last_insert_id()"; // Pastikan Anda mengganti "tiketID" dengan kolom yang sesuai sebagai primary key tiket
                            if ($koneksi->query($sql_insert_bukti) === TRUE) {
                                echo "alert('Tiket berhasil dipesan dan bukti pembayaran berhasil diunggah.')";
                                header('Location: tiket-saya.php');
                            } else {
                                echo "Gagal mengunggah bukti pembayaran.";
                            }
                        } else {
                            echo "Gagal mengunggah bukti pembayaran.";
                        }
                    } else {
                        echo "Format file bukti pembayaran harus PNG atau JPG/JPEG.";
                    }
                } else {
                    echo "Gagal mengunggah bukti pembayaran." . $_FILES['buktiPembayaran']['error'];
                }
            } else {
                echo "Gagal melakukan pemesanan tiket.";
            }
        } else {
            echo "Kursi sudah habis.";
        }
    } else {
        echo "Kesalahan dalam memeriksa kursi.";
    }
}
?>