<?php
$host = 'localhost';
$username = 'busharap_bus';
$password = 'busmpti2023';
$database = 'busharap_bus';

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die('Koneksi gagal: ' . $koneksi->connect_error);
}
?>