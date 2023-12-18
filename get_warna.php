<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "stok_unit";
$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$tipe_id = $_GET['tipe_id'];
$sql = "SELECT warna FROM warna WHERE tipe_id = '$tipe_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $warnaArray = array();
    while ($row = $result->fetch_assoc()) {
        $warnaArray[] = $row['warna'];
    }
    echo json_encode($warnaArray);
} else {
    echo json_encode(array("message" => "Tidak ada data warna yang ditemukan untuk tipe yang dipilih."));
}
$conn->close();
?>