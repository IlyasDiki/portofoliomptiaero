<?php
// Fungsi untuk memasukkan data bus ke database
function tambahDataBus($busID, $ruteID, $agen, $kelas, $tglBerangkat, $wktBerangkat, $harga, $jumlah_kursi)
{
    global $koneksi;
    $sql = "INSERT INTO bus (busID, ruteID, agen, kelas, tglBerangkat, wktBerangkat, harga, jumlah_kursi) VALUES ('$busID', '$ruteID', '$agen', '$kelas', '$tglBerangkat', '$wktBerangkat', '$harga', '$jumlah_kursi')";
    $result = $koneksi->query($sql);
    return $result;
}

// Fungsi untuk mendapatkan busID berikutnya dengan pola +1
function generateNextBusID($lastBusID)
{
    $num = substr($lastBusID, 3); // Ambil angka dari busID terakhir
    $nextNum = intval($num) + 1; // Tambahkan 1 ke angka terakhir
    $nextBusID = 'Bus' . str_pad($nextNum, 3, '0', STR_PAD_LEFT); // Buat busID baru dengan angka yang sudah diincrement
    return $nextBusID;
}

// Koneksi ke database (ganti dengan informasi koneksi sesuai dengan database Anda)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bus';
$koneksi = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Fungsi untuk menghasilkan tanggal dalam rentang 5 hingga 17 Agustus
function generateDates()
{
    $start_date = strtotime('2023-08-05');
    $end_date = strtotime('2023-08-17');

    $dates = array();
    while ($start_date <= $end_date) {
        $dates[] = date('Y-m-d', $start_date);
        $start_date = strtotime("+1 day", $start_date);
    }
    return $dates;
}

// Data bus yang akan diinputkan
$ruteID = "10002";
$agen = "Karangjati";
$kelas = "Eksekutif";
$wktBerangkat = "08:00:00";
$harga = 750000;
$jumlah_kursi = 40;

// Generate tanggal berangkat
$tglBerangkat_list = generateDates();

// Memasukkan data bus ke database untuk setiap tanggal berangkat
foreach ($tglBerangkat_list as $tglBerangkat) {
    tambahDataBus($busID, $ruteID, $agen, $kelas, $tglBerangkat, $wktBerangkat, $harga, $jumlah_kursi);
}

// Tutup koneksi ke database
$koneksi->close();
?>