<?php
session_start();
$server = "localhost";
$username = "root";
$password = "";
$dbname = "stok_unit";
$koneksi = mysqli_connect($server, $username, $password, $dbname);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $noRangkaView = $_POST['noRangkaView'];
    $noMutasiView = $_POST['noMutasiView'];
    $tanggalMutasiView = $_POST['tanggalmutasiView'];
    $lokasiAsalView = $_POST['lokasiAsalView'];
    $lokasiTujuanView = $_POST['lokasiTujuanView'];
    $picView = $_POST['picView'];
    $keteranganView = $_POST['keteranganView'];
    $postedDateView = $_POST['postedDateView'];

    // Simpan data ke database (sesuai kebutuhan Anda)
    $insert_query = "INSERT INTO mutasi (No_Rangka, No_Mutasi, Tanggal_Mutasi, Lokasi_Asal, Lokasi_Tujuan, PIC, Keterangan, PostedDate) 
                    VALUES ('$noRangkaView', '$noMutasiView', '$tanggalKirimView', '$lokasiAsalView', '$lokasiTujuanView', '$picView', '$keteranganView', '$postedDateView')";

    if (mysqli_query($koneksi, $insert_query)) {
        echo "Data berhasil direkam.";
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($koneksi);
    }
} else {
    echo "Akses tidak sah.";
}

mysqli_close($koneksi);
?>
