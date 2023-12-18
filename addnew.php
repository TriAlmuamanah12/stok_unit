<!DOCTYPE html>
<html>
<head>
    <title>Add New Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f0f0;
        }
        .container {
            margin-top: 20px;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
        }
        .form-group label {
            flex: 1;
        }
        .form-group label.required::after {
            content: " *";
            color: red;
        }
        .form-group input, .form-group select {
            flex: 2;
        }
        /* Tambahkan warna latar belakang dan teks untuk modal */
        .modal-content {
            background-color: #f8f9fa; /* Warna latar belakang modal */
            color: #495057; /* Warna teks modal */
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
    session_start();
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stok_unit"; 
    $conn = new mysqli($server, $username, $password, $dbname);   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $noRangka = $_POST['No_Rangka'];    
        if (strlen($noRangka) == 17) {
            $tipe_id = $_POST['Tipe'];
            $warna = $_POST['Warna'];
            $noMesin = $_POST['No_Mesin'];
            $tahun = $_POST['Tahun'];
            $lokasi = $_POST['Lokasi'];
            $tanggalBeli = $_POST['Tanggal_Beli'];
            $keterangan = $_POST['Keterangan']; 
            $sql = "INSERT INTO master_unit (No_Rangka, Tahun, Tanggal_Register, Warna, Tipe, No_Mesin, Lokasi, Keterangan) VALUES ('$noRangka', '$tahun', '$tanggalRegister', '$warna', '$tipe_id', '$noMesin', '$lokasi', '$keterangan')";
            if ($conn->query($sql) === TRUE) {
                echo '<div class="alert alert-success">Data berhasil ditambahkan!</div>';
                header("Location: index.php");
            } else {
                echo '<div class="alert alert-danger">Error: ' . $sql . '<br>' . $conn->error . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">No Rangka harus terdiri dari 17 karakter.</div>';
        }
    }
    ?>
    <div id="message" style="margin-top: 20px;"></div>
    <div class="modal" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewModalLabel">Tambah Data Baru</h5>
                </div>
                <div class="modal-body">
                    <form method="post">
                    <div class="form-group">
                            <label for="Tipe" class="required"><strong>Tipe</strong></label>
                            <select class="form-control" id="Tipe" name="Tipe" onchange="getWarnaByTipe(this);" required>
                                <option value="">Pilih Tipe</option>
                                <?php
                                $sql = "SELECT Id, Tipe FROM tipe";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['Tipe'] . "' data-id='" . $row['Id'] . "'>" . $row['Tipe'] . "</option>";
                                    }
                                } else {
                                    echo "Tidak ada data tipe yang ditemukan.";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Warna" class="required"><strong>Warna</strong></label>
                            <select class="form-control" id="Warna" name="Warna" required>
                                <option value="">Pilih Tipe terlebih dahulu</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="No_Rangka" class="required"><strong>No Rangka</strong></label>
                            <input type="text" class="form-control" id="No_Rangka" name="No_Rangka" required>
                        </div>
                        <div class="form-group">
                            <label for="No_Mesin" class="required"><strong>No Mesin</strong></label>
                            <input type="text" class="form-control" id="No_Mesin" name="No_Mesin" required>
                        </div>
                        <div class="form-group">
                            <label for="Tahun" class="required"><strong>Tahun</strong></label>
                            <input type="number" class="form-control" id="Tahun" name="Tahun" required>
                        </div>
                        <div class="form-group">
                            <label for="Lokasi" class="required"><strong>Lokasi</strong></label>
                            <input type="text" class="form-control" id="Lokasi" name="Lokasi" required>
                        </div>
                        <div class="form-group">
                            <label for="Tanggal_Register" class="required"><strong>Tgl Register</strong></label>
                            <input type="date" class="form-control" id="Tanggal_Register" name="Tanggal_Register" required>
                        </div>
                        <div class="form-group">
                            <label for="Keterangan" class="required"><strong>Keterangan</strong></label>
                            <input type="text" class="form-control" id="Keterangan" name="Keterangan" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                        <a class="btn btn-primary" href="index.php">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function getWarnaByTipe(tipeDropdown) {
            var warnaDropdown = document.getElementById('Warna');
            while (warnaDropdown.options.length > 0) {
                warnaDropdown.remove(0);
            }
            var tipe_id = tipeDropdown.options[tipeDropdown.selectedIndex].getAttribute('data-id');
            if (tipe_id) {
                fetch('get_warna.php?tipe_id=' + tipe_id)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(function(warna) {
                            var option = document.createElement('option');
                            option.text = warna;
                            option.value = warna;
                            warnaDropdown.add(option);
                        });
                    })
                    .catch(error => {
                        console.error('Gagal mengambil data warna: ' + error);
                    });
            } else {
                var option = document.createElement('option');
                option.text = "Pilih Tipe terlebih dahulu";
                option.value = "";
                warnaDropdown.add(option);
            }
        }
        $(document).ready(function() {
            $('#addNewModal').modal('show');
        });
        document.querySelector("form").addEventListener("submit", function(event) {
            var noRangkaInput = document.getElementById("No_Rangka");
            if (noRangkaInput.value.length !== 17) {
                alert("Error.");
                event.preventDefault();
            }
        });
    </script>
    <script>
    // Mendapatkan elemen input date berdasarkan ID
    var inputTanggalRegister = document.getElementById('Tanggal_Register');

    // Mendapatkan tanggal hari ini
    var today = new Date();

    // Format tanggal ke format YYYY-MM-DD
    var formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);

    // Setel nilai atribut value elemen input date
    inputTanggalRegister.value = formattedDate;
</script>
</body>
</html>
