<?php
// tambah_data.php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "stok_unit";

// Create connection
$koneksi = mysqli_connect($server, $username, $password, $dbname);

// Check connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming you have received the data from the AJAX request
$lokasiTujuan = $_POST['Lokasi_Tujuan'];
$tanggalMutasi = $_POST['Tanggal_Mutasi'];
$pic = $_POST['PIC'];
$keterangan = $_POST['Keterangan'];

// Basic validation, you may want to add more sophisticated validation
if (empty($lokasiTujuan) || empty($tanggalMutasi) || empty($pic) || empty($keterangan)) {
    echo "error";
    exit;
}

// Insert new data into the database
$query = "INSERT INTO master_unit (Lokasi_Tujuan, Tanggal_Mutasi, PIC, Keterangan) VALUES ('$lokasiTujuan', '$tanggalMutasi', '$pic', '$keterangan')";

if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Close connection
mysqli_close($koneksi);
?>
