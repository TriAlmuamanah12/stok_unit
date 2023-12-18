<?php
$server = "localhost"; // Host database (biasanya "localhost" jika dijalankan secara lokal)
$username = "root"; // Nama pengguna database
$password = ""; // Kata sandi database
$dbname = "login"; // Nama database

// Membuat koneksi database
$conn = new mysqli($server, $username, $password, $dbname);

// Memeriksa koneksi
if (mysqli_connect_error()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
