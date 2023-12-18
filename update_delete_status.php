<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "stok_unit";
$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['noRangka'])) {
    $noRangka = $_POST['noRangka'];
} elseif (isset($_GET['noRangka'])) {
    $noRangka = $_GET['noRangka'];
} else {
    die("Nomor Rangka tidak ditemukan.");
}
$sql = "UPDATE master_unit SET deleted = 1 WHERE No_Rangka = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $noRangka);
if ($stmt->execute()) {
    header('Location: index.php');
    exit; 
} else {
    echo 'error';
}
$stmt->close();
$conn->close();
?>
