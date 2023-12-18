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
    // Dapatkan data yang diperlukan dari POST
    $noRangka = $_POST["noRangka"];
    $noMutasi = $_POST["noMutasi"];

    // Update field PostedDate di tabel history
    $update_query = "UPDATE mutasi SET PostedDate = CURRENT_TIMESTAMP WHERE No_Rangka = ? AND no_mutasi = ?";

    // Gunakan prepared statement untuk mencegah SQL injection
    $stmt = mysqli_prepare($koneksi, $update_query);
    mysqli_stmt_bind_param($stmt, "ii", $noRangka, $noMutasi);

    $update_result = mysqli_stmt_execute($stmt);

    if (!$update_result) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

    mysqli_stmt_close($stmt);

    // Proses tambahan jika diperlukan
    // ...

    echo "Data berhasil diposting!";
}
?>
