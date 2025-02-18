<?php
// Mulai session
session_start();

// Hapus semua data session
session_unset();

// Hapus session dari server
session_destroy();

// Redirect pengguna ke halaman login atau halaman lain setelah logout
header("Location: login.php");
exit();
?>