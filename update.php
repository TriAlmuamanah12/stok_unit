<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noRangka = $_POST['No_Rangka'];
    $lokasiTujuan = $_POST['Lokasi_Tujuan'];
    $tanggalMutasi = $_POST['Tanggal_Mutasi'];
    $pic = $_POST['PIC'];
    $keterangan = $_POST['Keterangan'];

    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stok_unit";

    function connectToDatabase() {
        $koneksi = new mysqli($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        if ($koneksi->connect_error) {
            die("Koneksi ke database gagal: " . $koneksi->connect_error);
        }
        return $koneksi;
    }

    $createdBy = isset($_SESSION['username']) ? $_SESSION['username'] : 'default_user';

    try {
        $koneksi = connectToDatabase();
        if (!$koneksi) {
            die("Koneksi ke database gagal: " . mysqli_connect_error());
        }

        // Validasi Tanggal
        if (!strtotime($tanggalMutasi)) {
            echo 'Gagal: Format tanggal tidak valid.';
            exit;
        }

        $currentDateTime = date('Y-m-d H:i:s');
        $createdDate = $currentDateTime . '.' . substr((string) microtime(true), 2, 6);

        $queryCheckPendingMutasi = "SELECT COUNT(*) as jumlahPending FROM mutasi WHERE No_Rangka = ? AND postedDate IS NULL";
        $stmtCheckPendingMutasi = $koneksi->prepare($queryCheckPendingMutasi);
        $stmtCheckPendingMutasi->bind_param("s", $noRangka);
        $stmtCheckPendingMutasi->execute();
        $resultCheckPendingMutasi = $stmtCheckPendingMutasi->get_result();

        if ($resultCheckPendingMutasi && $resultCheckPendingMutasi->num_rows > 0) {
            $dataPendingMutasi = $resultCheckPendingMutasi->fetch_assoc();
            $jumlahPending = $dataPendingMutasi['jumlahPending'];

            if ($jumlahPending > 0) {
                echo 'Gagal: Masih ada data mutasi yang belum diposting untuk nomor rangka ini.';
                exit;
            }
        }

        $queryGetLokasiAsal = "SELECT Lokasi FROM master_unit WHERE No_Rangka = ?";
        $stmtGetLokasiAsal = $koneksi->prepare($queryGetLokasiAsal);
        $stmtGetLokasiAsal->bind_param("s", $noRangka);
        $stmtGetLokasiAsal->execute();
        $resultLokasiAsal = $stmtGetLokasiAsal->get_result();
        $lokasiAsal = '';

        if ($resultLokasiAsal && $resultLokasiAsal->num_rows > 0) {
            $dataLokasiAsal = $resultLokasiAsal->fetch_assoc();
            $lokasiAsal = $dataLokasiAsal['Lokasi'];
        }

        $koneksi->autocommit(FALSE);

        $queryInsertMutasi = "INSERT INTO mutasi (No_Rangka, Lokasi_Asal, Lokasi_Tujuan, Tanggal_Mutasi, PIC, Keterangan, createdBy, modifiedBy, createdDate, postedDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)";
        $stmtInsertMutasi = $koneksi->prepare($queryInsertMutasi);
        $stmtInsertMutasi->bind_param("sssssssss", $noRangka, $lokasiAsal, $lokasiTujuan, $tanggalMutasi, $pic, $keterangan, $createdBy, $createdBy, $createdDate);

        $stmtUpdateMaster_Unit = $koneksi->prepare("UPDATE master_unit SET Lokasi = ? WHERE No_Rangka = ?");
        $stmtUpdateMaster_Unit->bind_param("ss", $lokasiTujuan, $noRangka);

        if ($stmtInsertMutasi->execute() && $stmtUpdateMaster_Unit->execute()) {
            $koneksi->commit();
            echo 'success';
        } else {
            $koneksi->rollback();
            echo 'Gagal: Tidak dapat menyimpan mutasi. Silakan cek data input. Error: ' . $koneksi->error . ', ' . $stmtInsertMutasi->error . ', ' . $stmtUpdateMaster_Unit->error;
        }
    } catch (Exception $e) {
        $koneksi->rollback();
        echo 'Gagal: ' . $e->getMessage();
    } finally {
        if (isset($koneksi)) {
            $koneksi->autocommit(TRUE); // pastikan autocommit dikembalikan ke TRUE
            $koneksi->close();
        }
    }
} else {
    echo 'Metode yang diterima tidak valid.';
}
?>