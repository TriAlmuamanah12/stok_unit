<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .form-group {
            max-width: 400px;
            display: inline-block;
            margin-right: 20px;
            vertical-align: top;
        }

        .form-group:last-child {
            margin-right: 0;
        }

        .form-group,
        table {
            margin-bottom: 25px;
        }

        .table-buttons {
            display: flex;
            justify-content: space-between;
        }

        .table-buttons button {
            margin-right: 5px;
        }
    </style>
    </head>
<body>
<div class="container">
    <?php
    session_start();
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stok_unit";
    $koneksi = mysqli_connect($server, $username, $password, $dbname);
    if (!$koneksi) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }
    if (isset($_GET['record'])) {
        $noRangka = (int)$_GET['record'];
        $master_unit_query = "SELECT * FROM master_unit WHERE No_Rangka = $noRangka";
        $master_unit_result = mysqli_query($koneksi, $master_unit_query);

        if (!$master_unit_result) {
            die("Query gagal: " . mysqli_error($koneksi));
        }
        ?>
        <form>
            <?php
            while ($master_unit_data = mysqli_fetch_assoc($master_unit_result)) {
                echo "<div class='form-group'>";
                echo "<label>Tipe</label>";
                echo "<input type='text' class='form-control' value='" . htmlspecialchars($master_unit_data['Tipe']) . "' readonly>";
                echo "</div>";

                echo "<div class='form-group'>";
                echo "<label>Warna</label>";
                echo "<input type='text' class='form-control' value='" . htmlspecialchars($master_unit_data['Warna']) . "' readonly>";
                echo "</div>";

                echo "<div class='form-group'>";
                echo "<label>No Rangka</label>";
                echo "<input type='text' class='form-control' value='" . htmlspecialchars($master_unit_data['No_Rangka']) . "' readonly>";
                echo "</div>";

                echo "<div class='form-group'>";
                echo "<label>No Mesin</label>";
                echo "<input type='text' class='form-control' value='" . htmlspecialchars($master_unit_data['No_Mesin']) . "' readonly>";
                echo "</div>";

                echo "<div class='form-group'>";
                echo "<label>Tahun</label>";
                echo "<input type='text' class='form-control' value='" . htmlspecialchars($master_unit_data['Tahun']) . "' readonly>";
                echo "</div>";

                echo "<div class='form-group'>";
                echo "<label>Lokasi</label>";
                echo "<input type='text' class='form-control' value='" . htmlspecialchars($master_unit_data['Lokasi']) . "' readonly>";
                echo "</div>";

                echo "<div class='form-group'>";
                echo "<label>Tgl Register</label>";
                // Ubah format tanggal menggunakan date()
                $tanggalRegister = date('d-m-Y', strtotime($master_unit_data['Tanggal_Register']));
                echo "<input type='text' class='form-control' value='" . htmlspecialchars($tanggalRegister) . "' readonly>";
                echo "</div>";
                
                echo "<div class='form-group'>";
                echo "<label>Keterangan</label>";
                echo "<input type='text' class='form-control' value='" . htmlspecialchars($master_unit_data['Keterangan']) . "' readonly>";
                echo "</div>";
                
                
            }
            ?>
        </form>
        <?php
        } else {
            echo "Tidak ada nomor record yang dipilih.";
        }

        $query = "SELECT No_Rangka, No_Mutasi, Tanggal_Mutasi, Lokasi_Asal, Lokasi_Tujuan, PIC, Keterangan, PostedDate FROM mutasi WHERE No_Rangka = $noRangka";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query gagal: " . mysqli_error($koneksi));
        }
        if (mysqli_num_rows($result) > 0) {
            ?>
            <table class="table table-bordered table-striped table-sm">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">No Mutasi</th>
                    <th class="text-center">Tgl Mutasi</th>
                    <th>Lokasi Asal</th>
                    <th>Lokasi Tujuan</th>
                    <th>PIC</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tgl Terima</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
                <tbody>
                    <?php
                    while ($data_row = mysqli_fetch_assoc($result)) {
                        echo "<tr data-toggle='modal' data-target='#editHistoryModal'>";
                        echo "<td class='text-center'>MTS-" . date('ym', strtotime($data_row['Tanggal_Mutasi'])) . sprintf("%03d", htmlspecialchars($data_row['No_Mutasi'])) . "</td>";
                        echo "<td class='text-center'>" . date('d-m-Y', strtotime(htmlspecialchars($data_row['Tanggal_Mutasi']))) . "</td>";
                        echo "<td>" . htmlspecialchars($data_row['Lokasi_Asal']) . "</td>";
                        echo "<td>" . htmlspecialchars($data_row['Lokasi_Tujuan']) . "</td>";
                        echo "<td>" . htmlspecialchars($data_row['PIC']) . "</td>";
                        echo "<td>" . htmlspecialchars($data_row['Keterangan']) . "</td>";
                        echo "<td class='text-center'>";
                    if (!empty($data_row['PostedDate'])) {
                        echo date('d-m-Y', strtotime(htmlspecialchars($data_row['PostedDate'])));
                    }
                    echo "</td>";

                    echo "<td class='table-buttons text-center d-flex justify-content-center'>"; // Tambahkan kelas d-flex dan justify-content-center
                    if ($data_row['PostedDate'] != null) {
                        echo "<button class='btn btn-primary btn-sm view-btn' data-toggle='modal' data-target='#viewHistoryModal' data-no-rangka='" . htmlspecialchars($noRangka) . "'>View</button>";
                    } else {
                        echo "<button class='btn btn-warning btn-sm edit-btn' data-toggle='modal' data-target='#editHistoryModal' data-no-mutasi='" . htmlspecialchars($data_row['No_Mutasi']) . "'>Edit</button>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                    ?>
                    </tbody>
                </table>
                <?php
                }
                ?>
                <div class="text-center mb-4">
                    <button class="btn btn-primary" onclick="history.go(-1);">Kembali</button>
                </div>
            </div>
<!-- Modal Edit History -->
<div class="modal fade" id="editHistoryModal" tabindex="-1" role="dialog" aria-labelledby="editHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHistoryModalLabel">Edit History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulir Edit History -->
                <form method="post" action="proses_edit_history.php" id="formEditHistory">
                    <div class="form-group">
                        <label for="editNoMutasi">No Mutasi</label>
                        <input type="text" name="editNoMutasi" id="editNoMutasi" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="editTanggalMutasi">Tanggal Mutasi</label>
                        <input type="date" name="editTanggalMutasi" id="editTanggalMutasi" class="form-control" disabled>
                    </div>

                    <!-- Tambahkan class "readonly" pada input yang readonly -->
                    <div class="form-group readonly">
                        <label for="editLokasiAsal">Lokasi Asal</label>
                        <input type="text" name="editLokasiAsal" id="editLokasiAsal" class="form-control" readonly>
                    </div>

                    <div class="form-group readonly">
                        <label for="editLokasiTujuan">Lokasi Tujuan</label>
                        <input type="text" name="editLokasiTujuan" id="editLokasiTujuan" class="form-control" readonly>
                    </div>

                    <div class="form-group readonly">
                        <label for="editPIC">PIC</label>
                        <input type="text" name="editPIC" id="editPIC" class="form-control" readonly>
                    </div>

                    <div class="form-group readonly">
                        <label for="editKeterangan">Keterangan</label>
                        <textarea name="editKeterangan" id="editKeterangan" class="form-control" readonly></textarea>
                    </div>

                    <div class="form-group">
                    <label for="editTanggalTerima">Tanggal Terima<span style="color: red;">*</span></label>
                    <input type="date" name="editTanggalTerima" id="editTanggalTerima" class="form-control" required>
                </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="saveChanges">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>

                            <!-- Modal View History -->
                            <div class="modal fade" id="viewHistoryModal" tabindex="-1" role="dialog" aria-labelledby="viewHistoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewHistoryModalLabel">View History</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form View History -->
                                            <form method="post" action="proses_view_history.php" id="formViewHistory">
                                                <input type="hidden" name="noRangkaView" id="noRangkaView" value="">
                                                <div class="form-group">
                                                <label>No Mutasi</label>
                                                <input type="text" name="noMutasiView" id="noMutasiView" class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Mutasi</label>
                                                <input type="text" name="tanggalMutasiView" id="tanggalMutasiView" class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Lokasi Asal</label>
                                                <input type="text" name="lokasiAsalView" id="lokasiAsalView" class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Lokasi Tujuan</label>
                                                <input type="text" name="lokasiTujuanView" id="lokasiTujuanView" class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>PIC</label>
                                                <input type="text" name="picView" id="picView" class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <textarea name="keteranganView" id="keteranganView" class="form-control" readonly></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Terima</label>
                                                <input type="text" name="postedDateView" id="postedDateView" class="form-control" readonly>
                                            </div>
                                        </form>
                                        <!-- Tombol untuk menutup modal -->
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                        $(document).ready(function () {
                            // Event handler untuk menampilkan modal editHistoryModal
                            $('#editHistoryModal').on('show.bs.modal', function (event) {
                                var button = $(event.relatedTarget);
                                var noRangka = button.data('no-rangka');
                                var noMutasi = button.data('no-mutasi');
                                var tanggalMutasi = button.closest('tr').find('td:eq(1)').text();

                                // Mengatur nilai pada formulir untuk pengeditan
                                $('#noRangkaEdit').val(noRangka);
                                $('#noMutasiEdit').val(noMutasi);
                                $('#editNoMutasi').val(noMutasi);

                                // Mendapatkan tanggal saat ini untuk baris yang diedit
                                var currentDate = new Date(); // Anda mungkin perlu menyesuaikan ini berdasarkan format tanggal Anda
                                var formattedDate = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' + ('0' + currentDate.getDate()).slice(-2);

                                // Menetapkan tanggal yang diedit pada formulir
                                $('#editTanggalMutasi').val(formattedDate);

                                // ... (kolom formulir lainnya)

                                $('#editTanggalTerima').val(button.closest('tr').find('td:eq(6)').text());
                                $('#editLokasiAsal').val(button.closest('tr').find('td:eq(2)').text());
                                $('#editLokasiTujuan').val(button.closest('tr').find('td:eq(3)').text());
                                $('#editPIC').val(button.closest('tr').find('td:eq(4)').text());
                                $('#editKeterangan').val(button.closest('tr').find('td:eq(5)').text());
                            });

                            // Event handler untuk menyembunyikan modal editHistoryModal
                            $('#editHistoryModal').on('hidden.bs.modal', function () {
                                // Menyetel ulang formulir di dalam modal
                                $('#formEditHistory')[0].reset();
                            });

                            // Event handler untuk pengiriman formulirEditHistory
                            $('#formEditHistory').submit(function (event) {
                                event.preventDefault();

                                // Permintaan Ajax untuk mengirim data formulir
                                $.ajax({
                                    type: 'POST',
                                    url: 'update_posted_date.php',
                                    data: $(this).serialize(),
                                    success: function (response) {
                                        console.log("ini respon : " + response);
                                        alert('Data berhasil diubah dalam tabel history!');
                                        $('#editHistoryModal').modal('hide');
                                    },
                                    error: function (error) {
                                        console.error('Error:', error);
                                        alert('Terjadi kesalahan. Silakan coba lagi.');
                                    }
                                });
                            });

                            // Event handler untuk tombol posting
                            $('#postButton').click(function (event) {
                                event.preventDefault();

                                // Data tambahan untuk posting
                                var postedDate = $('#editTanggalMutasi').val();

                                // Permintaan Ajax untuk posting data
                                $.ajax({
                                    type: 'POST',
                                    url: 'proses_post_data.php',
                                    data: { postedDate: postedDate, /* Tambahkan data lain jika diperlukan */ },
                                    success: function (response) {
                                        console.log(response);
                                        alert('Data berhasil diposting!');
                                        $('#editHistoryModal').modal('hide');
                                    },
                                    error: function (error) {
                                        console.error('Error:', error);
                                        alert('Terjadi kesalahan. Silakan coba lagi.');
                                    }
                                });
                            });
                        });
                        </script>
                        <script>
                        // Event handler for viewHistoryModal
                        $('#viewHistoryModal').on('show.bs.modal', function (event) {
                            // Close the edit modal if it is open
                            $('#editHistoryModal').modal('hide');

                            var button = $(event.relatedTarget);
                            var noRangka = button.data('no-rangka');

                            // Isi nilai input pada form view
                            $('#noRangkaView').val(noRangka);
                            $('#noMutasiView').val(button.closest('tr').find('td:eq(0)').text());
                            $('#tanggalMutasiView').val(button.closest('tr').find('td:eq(1)').text());
                            $('#lokasiAsalView').val(button.closest('tr').find('td:eq(2)').text());
                            $('#lokasiTujuanView').val(button.closest('tr').find('td:eq(3)').text());
                            $('#picView').val(button.closest('tr').find('td:eq(4)').text());
                            $('#keteranganView').val(button.closest('tr').find('td:eq(5)').text());
                            $('#postedDateView').val(button.closest('tr').find('td:eq(6)').text());
                        });

                        // Event handler for formViewHistory submission
                        $('#formViewHistory').submit(function (event) {
                            event.preventDefault();
                            // Ajax request for submitting form data
                            $.ajax({
                                type: 'POST',
                                url: 'proses_view_history.php',
                                data: $(this).serialize(),
                                success: function (response) {
                                    console.log(response);
                                    alert('Data berhasil direkam ke tabel history!');

                                    // Tutup modal setelah berhasil direkam
                                    $('#viewHistoryModal').modal('hide');
                                },
                                error: function (error) {
                                    console.error('Error:', error);
                                    alert('Terjadi kesalahan. Silakan coba lagi.');
                                }
                            });
                            });
</script>
</body>
</html>