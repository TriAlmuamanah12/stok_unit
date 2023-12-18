<?php
$server = "localhost"; 
$username = "root"; 
$password = "";
$dbname = "stok_unit"; 

$koneksi = mysqli_connect($server, $username, $password, $dbname);
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $noRangka = $_POST["No_Rangka"];

    // Lakukan operasi posting data ke tabel (sesuai kebutuhan Anda)
    // Misalnya, Anda dapat menyimpan status posting di kolom database tertentu
    $query = "UPDATE master_unit SET Status_Posting = 'Posted' WHERE No_Rangka = '$noRangka'";
    
    if (mysqli_query($koneksi, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}

mysqli_close($koneksi);
?>
