<?php
$host = "localhost";
$user = "root"; // ganti jika bukan root
$pass = "";     // sesuaikan dengan password MySQL kamu
$db   = "belajar"; // ganti sesuai nama database kamu

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
