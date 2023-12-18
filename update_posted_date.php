<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "stok_unit";
$koneksi = mysqli_connect($server, $username, $password, $dbname);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

$noMutasi = $_POST['noMutasiEdit'];

// Set timezone to your desired timezone
date_default_timezone_set('Asia/Jakarta'); // Ganti dengan zona waktu yang sesuai

// Update PostedDate in the history table with the current date and time
$query_update = "UPDATE mutasi SET PostedDate = '".$_POST['editTanggalTerima']."' WHERE No_Mutasi = ".$noMutasi;
$result_update = mysqli_query($koneksi, $query_update);

if (!$result_update) {
    die("Query update gagal: " . mysqli_error($koneksi));
} else {
    echo "success";
}

mysqli_close($koneksi);
?>