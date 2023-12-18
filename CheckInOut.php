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
if (isset($_POST['No_Rangka'])) {
    $No_Rangka = $conn->real_escape_string($_POST['No_Rangka']);
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s A');
    $defaultWarna = 'merah';
    $defaultTipe = 'honda';  
    $sql = "SELECT * FROM master_unit WHERE No_Rangka = '$No_Rangka'";
    $query = $conn->query($sql);
    if ($query->num_rows < 1) {
        $_SESSION['error'] = 'Cannot find QRCode number ' . $No_Rangka;
    } else {
        $row = $query->fetch_assoc();
        $id = $row['No_Rangka'];
        $sql = "SELECT * FROM master_unit WHERE No_Rangka='$id' AND Tanggal_Register='$currentDate' AND Warna='$defaultWarna' AND Tipe='$defaultTipe'";
        $query = $conn->query($sql);
        if ($query->num_rows > 0) {
            $sql = "UPDATE master_unit SET Warna='$defaultWarna', Tipe='$defaultTipe' WHERE No_Rangka='$No_Rangka' AND Tanggal_Register='$currentDate'";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = 'Successfully Time Out: ' . $row['No_Rangka'] . ' ' . $currentDate;
            } else {
                $_SESSION['error'] = $conn->error;
            }
        } else {
            $sql = "INSERT INTO master_unit(No_Rangka, Tanggal_Beli, Warna, Tipe) VALUES ('$No_Rangka', '$currentDate', '$defaultWarna', '$defaultTipe')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = 'Successfully Time In: ' . $row['No_Rangka'] . ' ' . $currentDate;
            } else {
                $_SESSION['error'] = $conn->error;
            }
        }
    }
} else {
    $_SESSION['error'] = 'Please scan your QR Code number';
}
$conn->close();
header("location: index.php");
?>