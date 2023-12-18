<?php
session_start();
$server = "localhost";
$username = "root";
$password = "";
$dbname = "stok_unit";
$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$filename = 'scanRecord-' . date('Y-m-d') . '.csv';
$query = "SELECT No_Rangka, Tanggal_Register, Warna, Tipe FROM mutasi_unit";
$result = mysqli_query($conn, $query);
$file = fopen($filename, "w");
$headers = array("No_Rangka", "Tanggal_Register", "Warna", "Tipe");
fputcsv($file, $headers);
while ($row = mysqli_fetch_assoc($result)) { 
    $data = array($row['No_Rangka'], $row['Tanggal_Register'], $row['Warna'], $row['Tipe']);
    fputcsv($file, $data);
}
fclose($file);
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Type: application/csv");
header("Content-Length: " . filesize($filename)); 
readfile($filename);
unlink($filename); 
exit();
?>
