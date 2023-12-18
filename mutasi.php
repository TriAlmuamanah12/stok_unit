<!DOCTYPE html>
<html>
<head>
    <title>Data Tabel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-label {
            font-weight: bold;
        }
        .form-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .form-group .form-label {
            flex-basis: 30%;
        }
        .form-group input[type="text"],
        .form-group input[type="date"] {
            flex: 1;
        }
        .text-danger {
            color: red;
        }
        .modal-header {
            background-color: #007bff; /* Warna latar belakang header modal */
            color: #fff; /* Warna teks header modal */
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
        $query = "SELECT * FROM master_unit WHERE No_Rangka = $record_number AND posted = 0 ORDER BY No_Rangka ASC LIMIT 1";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query gagal: " . mysqli_error($koneksi));
        }

        $data_row = [];  // Initialize $data_row

        if (mysqli_num_rows($result) > 0) {
            $data_row = mysqli_fetch_assoc($result);
        ?>
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Mutasi Unit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                        <div class="modal-body">
                            <form method="post" action="simpan_data.php">
                            <div class="form-group">
                                    <label for="Tipe" class="form-label">Tipe</label>
                                    <input type="text" class="form-control" id="Tipe" value="<?php echo $data_row['Tipe']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="Warna" class="form-label">Warna</label>
                                    <input type="text" class="form-control" id="Warna" value="<?php echo $data_row['Warna']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="No_Rangka" class="form-label">No Rangka</label>
                                    <input type="text" class="form-control" id="No_Rangka" value="<?php echo $data_row['No_Rangka']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="No_Mesin" class="form-label">No Mesin</label>
                                    <input type="text" class="form-control" id="No_Mesin" value="<?php echo $data_row['No_Mesin']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="Tahun" class="form-label">Tahun</label>
                                    <input type="text" class="form-control" id="Tahun" value="<?php echo $data_row['Tahun']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="Lokasi" class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" id="Lokasi" value="<?php echo $data_row['Lokasi']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="Tanggal_Register" class="form-label">Tgl Register</label>
                                    <?php
                                    // Ambil nilai tanggal dari $data_row
                                    $tanggalRegister = $data_row['Tanggal_Register'];

                                    // Jika $tanggalRegister tidak kosong, format tanggal
                                    if (!empty($tanggalRegister)) {
                                        $formattedDate = date('d-m-Y', strtotime($tanggalRegister));
                                    } else {
                                        $formattedDate = ''; // Atur ke string kosong jika $tanggalRegister kosong
                                    }
                                    ?>
                                    <input type="text" class="form-control" id="Tanggal_Register" value="<?php echo $formattedDate; ?>" readonly>
                                </div>

                               
                                <div class="form-group">
                                    <label for="Lokasi_Tujuan" class="form-label">Lokasi Tujuan<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="Lokasi_Tujuan" name="Lokasi_Tujuan" value="<?php echo isset($data_row['Lokasi_Tujuan']) ? $data_row['Lokasi_Tujuan'] : ''; ?>" required>
                                    <span style="color: red;" id="lokasiTujuanError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="Tanggal_Mutasi" class="form-label">Tanggal Mutasi<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="Tanggal_Mutasi" name="Tanggal_Mutasi" value="<?php echo isset($data_row['Tanggal_Mutasi']) ? $data_row['Tanggal_Mutasi'] : ''; ?>" required>
                                    <span style="color: red;" id="tanggalMutasiError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="PIC" class="form-label">PIC<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="PIC" name="PIC" value="<?php echo isset($data_row['PIC']) ? $data_row['PIC'] : ''; ?>" required>
                                    <span style="color: red;" id="picError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="Keterangan" class="form-label">Keterangan<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="Keterangan" name="Keterangan" value="<?php echo isset($data_row['Keterangan']) ? $data_row['Keterangan'] : ''; ?>" required>
                                    <span style="color: red;" id="keteranganError"></span>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="updateButton">Simpan Perubahan</button>
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
            $statusMessage = isset($data_row['Status']) && $data_row['Status'] == 1 ? "Data sudah diposting. Tidak bisa menambahkan data baru." : "Data tidak ditemukan.";
            echo "<p>$statusMessage</p>";
        }

        mysqli_close($koneksi);
    ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Your existing JavaScript code for #updateButton

            $("#modal").on("hidden.bs.modal", function () {
                window.location.href = 'edit.php'; // Adjust this to your desired redirection
            });
        });
    </script>
    <script>
$(document).ready(function() {
    $("#modal").modal("show");
    var originalValues = {
            Lokasi_Tujuan: "<?php echo isset($data_row['Lokasi_Tujuan']) ? $data_row['Lokasi_Tujuan'] : ''; ?>",
            Tanggal_Mutasi: "<?php echo isset($data_row['Tanggal_Mutasi']) ? $data_row['Tanggal_Mutasi'] : ''; ?>",
            PIC: "<?php echo isset($data_row['PIC']) ? $data_row['PIC'] : ''; ?>",
            Keterangan: "<?php echo isset($data_row['Keterangan']) ? $data_row['Keterangan'] : ''; ?>"
        };
    $("#updateButton").click(function() {
        var noRangka = "<?php echo $data_row['No_Rangka']; ?>";
        var lokasiTujuan = $("#Lokasi_Tujuan").val();
        var tanggalMutasi = $("#Tanggal_Mutasi").val();
        var pic = $("#PIC").val();
        var keterangan = $("#Keterangan").val();
        var errors = false;

        if (lokasiTujuan === "") {
            $("#lokasiTujuanError").text("Lokasi Tujuan harus diisi");
            errors = true;
        } else {
            $("#lokasiTujuanError").text("");
        }

        if (tanggalMutasi === "") {
            $("#tanggalMutasiError").text("Tanggal Mutasi harus diisi");
            errors = true;
        } else {
            $("#tanggalMutasiError").text("");
        }

        if (pic === "") {
            $("#picError").text("PIC harus diisi");
            errors = true;
        } else {
            $("#picError").text("");
        }

        if (keterangan === "") {
            $("#keteranganError").text("Keterangan harus diisi");
            errors = true;
        } else {
            $("#keteranganError").text("");
        }

        if (errors) {
            return;
        }
        

        $.ajax({
            url: 'update.php',
            method: 'POST',
            data: {
                No_Rangka: noRangka,
                Lokasi_Tujuan: lokasiTujuan,
                Tanggal_Mutasi: tanggalMutasi,
                PIC: pic,
                Keterangan: keterangan
            },
            success: function(response) {
                if (response === 'success') {
                    alert('Data berhasil diperbarui.');
                    $('#modal').modal('hide');
                    updateDataView();
                } else {
                    alert('Proses dibatalkan karena masih terdapat transaksi mutasi yang masih berjalan.Silahkan selesaikan terlebih dahulu sebelum membuat transaksi baru.');
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menghubungi server. Silakan coba lagi.');
            }
        });
    });

    $("#Lokasi_Tujuan").on("input", function() {
        $("#lokasiTujuanError").text("");
    });

    $("#Tanggal_Mutasi").on("input", function() {
        $("#tanggalMutasiError").text("");
    });

    $("#PIC").on("input", function() {
        $("#picError").text("");
    });

    $("#Keterangan").on("input", function() {
        $("#keteranganError").text("");
    });

    $('#modal').on('hidden.bs.modal', function () {
        window.location.href = 'index.php';
    });
});
</script>
</body>
</html>