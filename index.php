<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Ganti "login.php" dengan halaman login yang benar
    exit;
}

// Di sini Anda dapat menampilkan konten yang sesuai dengan pengguna yang sudah login
$username = $_SESSION['username'];
$createdBy = $_SESSION['CreatedBy'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title>QR Code Scanner</title>
    <script type="text/javascript" src="js/instascan.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background: #eee;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .navbar-header {
            display: flex;
            align-items: center;
        }

        .hello-text {
            margin-right: 10px;
        }

        /* Adjust other styles for mobile responsiveness... */

        @media (max-width: 767px) {
            .col-md-4,
            .col-md-8 {
                width: 100%;
            }
        }
    </style>
</head>
<body style="background:#eee" onload="startScanner(0)">
<nav class="navbar" style="background:#2c3e50">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#"> <i class="glyphicon glyphicon-qrcode"></i> QR Code</a>
        </div>
        <div class="navbar-header" style="float: right;">
        <span style="color: white; margin-right: 10px; display: inline-block; float: right; margin-top: 15px;" class="hello-text">Hello, <?php echo $username; ?></span>
        <a class="navbar-brand" href="logout.php" style="color: white; margin-top: 15px; font-size: inherit;" class="logoff-text">Log off</a>
    </div>
    </div>
</nav>

    <div class="container">
        <div class="row">
            <div class="col-md-4" style="padding:10px;background:#fff;border-radius: 5px;" id="divvideo">
                <center><p class="login-box-msg"> <i class="glyphicon glyphicon-camera"></i> TAP HERE</p></center>
                <video id="preview" width="100%" height="50%" style="border-radius:10px;" autoplay playsinline></video>
                <br>
                <br>
                <button onclick="changeCamera()">Ganti Kamera</button>
                <div id="scanResult"></div>
            </div>
            <div class="col-md-8">
                <form action="CheckInOut.php" method="post" class="form-horizontal" style="border-radius: 5px; padding: 10px; background: #fff;" id="formScan">
                    <i class="glyphicon glyphicon-qrcode"></i> <label>SCAN QR CODE</label> <p id="time"></p>
                    <input type="text" name="No_Rangka" id="barcodeResult" placeholder="scan qrcode" class="form-control" autofocus>
                </form>
                <div style="border-radius: 5px; padding: 10px; background: #fff;" id="divvideo">
                    <a href="addnew.php" class="btn btn-success">Add New</a>
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tipe</th>
                                <th>Warna</th>
                                <th>No Rangka</th>
                                <th>No Mesin</th>
                                <th>Tahun</th>
                                <th>Lokasi</th>
                                <th>Tgl Register</th>
                                <th>Keterangan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $server = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "stok_unit";
                            $conn = new mysqli($server, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $sql = "SELECT * FROM master_unit";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    if ($row['Deleted'] == 1) {
                                        continue;
                                    }
                                    echo "<tr data-no-rangka='" . $row['No_Rangka'] . "'>";
                                    echo "<td>" . $row['Tipe'] . "</td>";
                                    echo "<td>" . $row['Warna'] . "</td>";
                                    echo "<td>" . $row['No_Rangka'] . "</td>";
                                    echo "<td>" . $row['No_Mesin'] . "</td>";
                                    echo "<td>" . $row['Tahun'] . "</td>";
                                    echo "<td>" . $row['Lokasi'] . "</td>";
                                    echo "<td class='text-center'>" . date('d-m-Y', strtotime($row['Tanggal_Register'])) . "</td>"; // Tanggal_Beli di tengah 
                                    echo "<td>" . $row['Keterangan'] . "</td>";
                                    echo "<td>
                                        <a class='btn btn-primary btn-sm' href='edit.php?record=" . $row['No_Rangka'] . "'>Edit</a>
                                        <a class='btn btn-primary btn-sm' href='mutasi.php?record=" . $row['No_Rangka'] . "'>Mutasi</a>
                                        <a class='btn btn-primary btn-sm' href='history.php?record=" . $row['No_Rangka'] . "'>History</a>
                                        <a class='btn btn-primary btn-sm delete-button' data-no-rangka='" . $row['No_Rangka'] . "'>NonActive</a>
                                    </td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/instascan@2.0.0/dist/instascan.min.js"></script>
    <script>
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            mirror: false
        });
        function startScanner(cameraIndex) {
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    let rearCamera = cameras.find(function (camera) {
                        return camera.name.indexOf('back') !== -1;
                    });
                    if (rearCamera) {
                        scanner.start(rearCamera);
                    } else {
                        scanner.start(cameras[cameraIndex]);
                    }
                } else {
                    alert('Tidak ada kamera yang ditemukan');
                }
            }).catch(function (e) {
                console.error(e);
            });
        }
        scanner.addListener('scan', function (content) {
            var scannedBarcode = content;
            document.getElementById('barcodeResult').value = scannedBarcode;
            document.getElementById('scanResult').innerText = 'Barcode: ' + scannedBarcode;
            processScannedBarcode(scannedBarcode);
        });
        function changeCamera() {
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 1) {
                    let rearCamera = cameras.find(function (camera) {
                        return camera.name.indexOf('back') !== -1;
                    });
                    if (rearCamera) {
                        scanner.start(rearCamera);
                    }
                }
            }).catch(function (e) {
                console.error(e);
            });
        }
        startScanner(0);
        function processScannedBarcode(content) {
            $.ajax({
                type: 'POST',
                url: 'process_barcode.php',
                data: { barcode: content },
                success: function (response) {
                    console.log('Respon dari server: ' + response);
                },
                error: function () {
                    console.error('Kesalahan dalam pemrosesan kode QR di server.');
                }
            });
        }
    </script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
    function processScannedBarcode(scannedBarcode) {
        if (scannedBarcode) {
            window.location.href = 'view.php?record=' + scannedBarcode;
        }
    }
</script>
<script>
$(document).ready(function () {
    $('.delete-button').click(function () {
        var deleteButton = $(this);
        var noRangka = deleteButton.data('no-rangka');   
        if (confirm('Apakah Anda yakin ingin menghapus baris ini?')) {
            $.ajax({
                type: 'POST',
                url: 'update_delete_status.php', 
                data: { noRangka: noRangka },
                success: function (response) {
                    if (response === 'success') {
                        var tableRow = deleteButton.closest('tr');
                        tableRow.hide();
                    }
                },
                error: function () {
                    console.error('Kesalahan dalam pemrosesan kode QR di server.');
                }
            });
        }
    });
});
</script>
<script>
$(document).ready(function () {
    $(document).on("click", ".delete-button", function () {
        var noRangka = $(this).data("no-rangka");
        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            window.location.href = "update_delete_status.php?noRangka=" + noRangka;
        }
    });
});
</script>
<script>
$("#updateButton").click(function() {
    var lokasiTujuan = $("#Lokasi_Tujuan").val();
    var tanggalKirim = $("#Tanggal_Kirim").val();
    $.ajax({
        url: 'update.php',
        method: 'POST',
        data: {
            No_Rangka: "<?php echo $data_row['No_Rangka']; ?>",
            Lokasi_Tujuan: lokasiTujuan,
            Tanggal_Kirim: tanggalKirim
        },
        success: function(response) {
            if (response === 'success') {
                alert('Data berhasil diperbarui.');
                $('#modal').modal('hide');
                updateDataView();
            } else {
                alert('Gagal memperbarui data.');
            }
        }
    });
});
</script>
<script>
        function redirectToLogin() {
            window.location.href = "login.php";
        }
    </script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>
</html>