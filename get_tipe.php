<!DOCTYPE html>
<html>
<head>
    <title>Form Contoh</title>
</head>
<body>
    <form action="proses.php" method="post">
        <label for="tipe">Pilih Tipe:</label>
        <select name="tipe" id="tipe" style="height: 50px;">
            <?php
            $server = "localhost";
            $username = "root";
            $password = "";
            $dbname = "stok_unit";
            $conn = new mysqli($server, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
             $sql = "SELECT * FROM tipe";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['tipe'] . '</option>';
                }
            }
            $conn->close();
            ?>
        </select>
        <input type="submit" value="Submit">
    </form>
</body>
</html>