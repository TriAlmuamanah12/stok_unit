<!DOCTYPE html>
<html>
<head>
    <title>Data Tabel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .modal-body .form-group {
        display: flex;
        align-items: center;
        margin: 5px 0; 
    }
    .modal-body label {
        flex: 1;
    }
    .modal-body input {
        flex: 2;
        margin: 0 5px;
    }
</style>
</head>
<body>
<div class="container">
<?php
    $server = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "stok_unit"; 
    $koneksi = mysqli_connect($server, $username, $password, $dbname);
    if (!$koneksi) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }
    $record_number = isset($_GET['record']) ? (int)$_GET['record'] : 1;
    $query = "SELECT * FROM mutasi_unit WHERE No_Rangka = " . $record_number . " ORDER BY No_Rangka ASC LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        die("Query gagal: " . mysqli_error($koneksi));
    }
    if (mysqli_num_rows($result) > 0) {
        $data_row = mysqli_fetch_assoc($result);
    ?>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel"><?php echo $data_row['No_Rangka']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                        <div class="form-group">
                                <label for="Tipe"><strong>Tipe</strong></label>
                                <input type="text" class="form-control" id="Tipe" value="<?php echo $data_row['Tipe']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Warna"><strong>Warna</strong></label>
                                <input type="text" class="form-control" id="Warna" value="<?php echo $data_row['Warna']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="No_Rangka"><strong>No Rangka</strong></label>
                                <input type="text" class="form-control" id="No_Rangka" value="<?php echo $data_row['No_Rangka']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="No_Mesin"><strong>No Mesin</strong></label>
                                <input type="text" class="form-control" id="No_Mesin" value="<?php echo $data_row['No_Mesin']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Tahun"><strong>Tahun</strong></label>
                                <input type="text" class="form-control" id="Tahun" value="<?php echo $data_row['Tahun']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Lokasi"><strong>Lokasi:</strong></label>
                                <input type="text" class="form-control" id="Lokasi" value="<?php echo $data_row['Lokasi']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Tanggal_Register"><strong>Tgl Register</strong></label>
                                <input type="text" class="form-control" id="Tanggal_Register" value="<?php echo $data_row['Tanggal_Register']; ?>" readonly>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
        echo "Tidak ada data yang ditemukan.";
    }
    mysqli_close($koneksi);
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $("#modal").modal("show");
    });
    $('#modal').on('hidden.bs.modal', function () {
        window.location.href = 'index.php';
    });
</script>
</body>
</html>