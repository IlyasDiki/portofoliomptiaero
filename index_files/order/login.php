<?php
session_start();
require '../koneksi.php';

// Fungsi untuk login
function login()
{
    // Inisialisasi koneksi ke database
    $koneksi = new mysqli("localhost", "root", "", "bus");

    if ($koneksi->connect_error) {
        die("Koneksi ke database gagal: " . $koneksi->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Lakukan validasi data jika diperlukan

        $sql_login = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
        $result_login = $koneksi->query($sql_login);

        if ($result_login->num_rows == 1) {
            $row = $result_login->fetch_assoc();
            $_SESSION['userID'] = $row['userID'];
            header("Location: ../index.php");
            die();
        } else {
            $error_msg = "Username atau password salah.";
        }

        // Tutup koneksi setelah digunakan
        $koneksi->close();
    }
}

// Fungsi untuk register
function register()
{
    // Inisialisasi koneksi ke database
    $koneksi = new mysqli("localhost", "root", "", "bus");

    if ($koneksi->connect_error) {
        die("Koneksi ke database gagal: " . $koneksi->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
        $nama = $_POST['nama'];
        $no_wa = $_POST['no_wa'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Lakukan validasi data jika diperlukan

        // Cek apakah email sudah terdaftar
        $sql_cek_email = "SELECT * FROM user WHERE email = '$email'";
        $result_cek_email = $koneksi->query($sql_cek_email);

        if ($result_cek_email->num_rows > 0) {
            echo "Email sudah terdaftar. Silakan gunakan email lain.";
        } else {
            // Jika email belum terdaftar, lakukan pendaftaran user
            $sql_daftar_user = "INSERT INTO user (nama, no_wa, email, username, password) VALUES ('$nama', '$no_wa', '$email', '$username', '$password')";

            if ($koneksi->query($sql_daftar_user) === TRUE) {
                echo "Pendaftaran user berhasil.";
                header("index.php");
            } else {
                echo "Terjadi kesalahan dalam pendaftaran user: " . $koneksi->connect_error;
            }
        }

        // Tutup koneksi setelah digunakan
        $koneksi->close();
    }
}

// Panggil fungsi login dan register berdasarkan kondisi tombol yang ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signin'])) {
        login();
    } elseif (isset($_POST['signup'])) {
        register();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../assets/css/login.css">
    <title>Halaman Login</title>
</head>
<body>
<h2>Halaman Login</h2>

<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="" method="post">
			<h1>Buat Akun</h1>
			<input type="text" placeholder="Nama" name="nama" autocomplete="off" required/>
			<input type="text" placeholder="No Whatsapp" name="no_wa" autocomplete="off"required />
			<input type="email" placeholder="Email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" autocomplete="off" required/>
			<input type="text" placeholder="Username" name="username" autocomplete="off" required/>
			<input type="password" placeholder="Password (minimal 8 karakter, harus mengandung huruf dan nomor)" name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" autocomplete="off" required
            oninvalid="this.setCustomValidity('Password harus terdiri dari minimal 8 karakter dan mengandung setidaknya satu huruf dan satu angka.')"
            onchange="this.setCustomValidity('')">
			<button type="submit" name="signup">Daftar</button>
		</form>
        <?php if (isset($error_msg)) echo $error_msg; ?>
	</div>
	<div class="form-container sign-in-container">
    <a href="../index.php"><h1 style=color:red;><</h1></a>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<h1>Login</h1>
			
			<input type="username" placeholder="Username" name="username" autocomplete="off" required/>
			<input type="password" placeholder="Password" name="password" autocomplete="off" required/>
			
			<button type="submit" name="signin">Login</button>
		</form>
        <?php if (isset($error_msg)) echo $error_msg; ?>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Punya Akun?</h1>
				<p></p>
				<button class="ghost" id="signIn">Login</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Selamat Datang</h1>
				<p>Untuk bisa dapatkan tiket, silahkan daftar terlebih dahulu</p>
				<button class="ghost" id="signUp" name="signup">Daftar</button>
			</div>
		</div>
	</div>
</div>


<script src="../assets/js/login.js"></script>   
</body>
</html>