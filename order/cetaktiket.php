<?php
session_start();
require '../koneksi.php';

if (empty($_SESSION['userID']) || $_SESSION['userID'] == '') {
    header("Location: ../order/index.php");
    die();
}

if (isset($_GET['tiketID'])) {
    $tiketID = $_GET['tiketID'];

    // Ambil informasi tiket dari database
    $sql_tiket = "SELECT * FROM tiket
    INNER JOIN bus ON tiket.busID = bus.busID
    WHERE tiket.tiketID = $tiketID";
    $result_tiket = $koneksi->query($sql_tiket);

    if ($result_tiket->num_rows > 0) {
        $tiket = $result_tiket->fetch_assoc();
    } else {
        echo "Tiket tidak ditemukan.";
        die();
    }
} else {
    echo "Tiket tidak ditemukan.";
    die();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cetak Tiket</title>
    <!-- Tambahkan tag HTML untuk link CSS atau gaya tampilan jika diperlukan -->
    <!-- Tambahkan tag HTML untuk link CSS atau gaya tampilan jika diperlukan -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        .ticket-container {
            text-align: center;
            margin: 20px auto;
            padding: 20px;
            max-width: 400px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            position: relative;
        }

        .ticket-container:before {
            content: "";
            position: absolute;
            top: -10px;
            left: 50%;
            margin-left: -10px;
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 10px solid #ccc;
        }

        .ticket-container h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .ticket-container hr {
            margin: 15px 0;
            border: 0;
            border-top: 1px dashed #ccc;
        }

        .ticket-container h3 {
            margin-bottom: 5px;
            color: #555;
        }

        .ticket-container p {
            margin: 5px 0;
        }

        .ticket-container p strong {
            color: #333;
        }

        .ticket-container p span {
            font-size: 14px;
            color: #777;
        }

        .ticket-container p em {
            font-style: italic;
            color: #666;
        }

        .ticket-container p:before,
        .ticket-container p:after {
            content: "";
            display: block;
            height: 2px;
            width: 30%;
            background: #ccc;
            position: absolute;
        }

        .ticket-container p:before {
            top: 0;
        }

        .ticket-container p:after {
            bottom: 0;
        }

        .ticket-container .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #fff;
            margin: 0 auto;
            position: relative;
            top: -40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 5px solid #ccc;
        }

        .ticket-container .logo img {
            display: block;
            width: 60%;
            height: 60%;
            margin: 20% auto;
        }
    </style>
</head>

<body>
    <div class="ticket-container">
    <div style="text-align: center;">
        <h2>Tiket Pemesanan Bus</h2>
        <hr>
        <h3>Informasi Tiket:</h3>
        <p>
            <strong>Nomor Tiket:</strong>
            <?php echo $tiket['tiketID']; ?><br>
            <strong>Agen:</strong>
            <?php echo $tiket['agen']; ?><br>
            <strong>Kelas:</strong>
            <?php echo $tiket['kelas']; ?><br>
            <strong>Tanggal Berangkat:</strong>
            <?php echo $tiket['tglBerangkat']; ?><br>
            <strong>Waktu Keberangkatan:</strong>
            <?php echo $tiket['wktBerangkat']; ?><br>
            <strong>Nomor Kursi:</strong>
            <?php echo $tiket['noKursi']; ?><br>
        </p>
        <hr>
        <p>Silahkan tunjukkan tiket ini saat melakukan perjalanan. Terima kasih telah menggunakan layanan kami!</p>
    </div>
    </div>
</body>

</html>