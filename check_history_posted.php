<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "stok_unit";
$koneksi = mysqli_connect($server, $username, $password, $dbname);

$response = [];

if (!$koneksi) {
    $response['status'] = 'error';
    $response['message'] = 'Connection to the database failed: ' . mysqli_connect_error();
} else {
    $noRangka = mysqli_real_escape_string($koneksi, $_POST['No_Rangka']);

    $query = "SELECT * FROM mutasi WHERE No_Rangka = '$noRangka' AND (Lokasi_Tujuan IS NOT NULL OR Lokasi_Tujuan <> '')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $response['status'] = 'posted';
        } else {
            $response['status'] = 'not_posted';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Query error: ' . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);
}

header('Content-Type: application/json');
echo json_encode($response);
?>
