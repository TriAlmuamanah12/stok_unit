<?php
// save_data.php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "stok_unit";

$koneksi = mysqli_connect($server, $username, $password, $dbname);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

$noRangka = mysqli_real_escape_string($koneksi, $_POST['No_Rangka']);
$lokasiTujuan = mysqli_real_escape_string($koneksi, $_POST['Lokasi_Tujuan']);
$tanggalMutasi = mysqli_real_escape_string($koneksi, $_POST['Tanggal_Mutasi']);
$pic = mysqli_real_escape_string($koneksi, $_POST['PIC']);
$keterangan = mysqli_real_escape_string($koneksi, $_POST['Keterangan']);

$query = "UPDATE master_unit SET Lokasi_Tujuan='$lokasiTujuan', Tanggal_Mutasi='$tanggalMutasi', PIC='$pic', Keterangan='$keterangan' WHERE No_Rangka='$noRangka'";

if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>
