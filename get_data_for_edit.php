<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Ambil data dari database berdasarkan $id dan masukkan ke dalam respons JSON
    $data = array('id' => $id, 'field_lain' => 'nilai_lain');
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Tidak ada id yang diberikan']);
}
?>
