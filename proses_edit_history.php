<?php
// proses_edit_history.php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["saveChanges"])) {
    // ...
    $noRangkaEdit = $_POST['noRangkaEdit'];
    $noMutasiEdit = $_POST['noMutasiEdit'];
    $editTanggalTerima = $_POST['editTanggalTerima'];
    // ...

    // Perbarui tabel dengan nomor mutasi
    $updateQuery = "UPDATE mutasi SET Tanggal_Terima = ? WHERE No_Rangka = ? AND No_Mutasi = ?";
    $stmt = mysqli_prepare($koneksi, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ssi", $editTanggalTerima, $noRangkaEdit, $noMutasiEdit);
    
    if (mysqli_stmt_execute($stmt)) {
        // Berhasil melakukan update
        echo "Data berhasil diubah dalam tabel history!";
    } else {
        // Gagal melakukan update
        echo "Gagal mengubah data dalam tabel history: " . mysqli_error($koneksi);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);
}
?>
