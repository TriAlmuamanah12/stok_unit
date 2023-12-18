<!DOCTYPE html>
<html>
<head>
    <title>Data Tabel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-group.row {
            margin-bottom: 5px;
        }
        .col-form-label {
            padding: 5px;
        }
        .form-control {
            padding: 5px;
        }
        .modal-header {
            background-color: #007bff; /* Warna latar belakang header modal */
            color: #fff; /* Warna teks header modal */
        }
    </style>
</head>
<body>
    <?php
    $conn = new mysqli("localhost", "root", "", "stok_unit");
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    function getData($conn) {
        $data_row = array(
            'No_Rangka' => '',
            'Tanggal_Beli' => '',
            'Warna' => '',
            'Tipe' => '',
            'No_Mesin' => '',
            'Cabang' => '',
            'Lokasi' => '',
            'Tahun' => ''
        );
        if (isset($_GET['record'])) {
            $No_Rangka = $_GET['record'];
            $sql = "SELECT * FROM master_unit WHERE No_Rangka = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $No_Rangka);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $data_row = $row;
                }
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
        return $data_row;
    }
    $data_row = getData($conn);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $warna = $_POST['Warna'];
        $tipe = $_POST['Tipe'];
        $no_rangka = $_POST['No_Rangka'];
        $no_mesin = $_POST['No_Mesin'];
        $tahun = $_POST['Tahun'];
        $lokasi = $_POST['Lokasi'];
        $tanggal_beli = $_POST['Tanggal_Beli'];
        $keterangan = $_POST['Keterangan'];
        $sql = "UPDATE master_unit SET Tipe = ?, Warna = ?, No_Mesin = ?, Tahun = ?, Lokasi = ?, Tanggal_Register = ?,  Keterangan = ? WHERE No_Rangka = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $tipe, $warna, $no_mesin, $tahun, $lokasi, $tanggal_beli, $keterangan, $no_rangka);
        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    ?>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?record=<?= $data_row['No_Rangka']; ?>">
                        <input type="hidden" name="id" value="<?= $data_row['No_Rangka'] ?>">
                        <div class="form-group row">
                            <label for="Tipe" class="col-sm-3 col-form-label"><strong>Tipe</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="Tipe" value="<?= $data_row['Tipe']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Warna" class="col-sm-3 col-form-label"><strong>Warna</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="Warna" value="<?= $data_row['Warna']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="No_Rangka" class="col-sm-3 col-form-label"><strong>No Rangka</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="No_Rangka" value="<?= $data_row['No_Rangka']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="No_Mesin" class="col-sm-3 col-form-label"><strong>No Mesin</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="No_Mesin" value="<?= $data_row['No_Mesin']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Tahun" class="col-sm-3 col-form-label"><strong>Tahun</strong></label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="Tahun" value="<?= $data_row['Tahun']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Lokasi" class="col-sm-3 col-form-label"><strong>Lokasi</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="Lokasi" value="<?= $data_row['Lokasi']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Tanggal_Register" class="col-sm-3 col-form-label"><strong>Tgl Register</strong></label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="Tanggal_Register" value="<?= $data_row['Tanggal_Register']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Keterangan" class="col-sm-3 col-form-label"><strong>Keterangan</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="Keterangan" value="<?= $data_row['Keterangan']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-3">
                                <button type="submit" class="btn btn-primary">Edit</button>
                                <a href="index.php" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#modal').modal('show');
        });
    </script>
</body>
</html>
