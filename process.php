<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simpan kredensial database Anda di bawah ini
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stok_unit";

    // Terhubung ke database
    $conn = new mysqli($server, $username, $password, $dbname);

    // Periksa koneksi database
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    // Ambil data dari form login
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Hindari SQL Injection dengan menggunakan prepared statement
    $sql = "SELECT * FROM login WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $input_username, $input_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Username dan password cocok
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['CreatedBy'] = $row['CreatedBy']; // Sesuaikan dengan kolom yang sesuai
        $login_success = true;
    } else {
        $_SESSION['error'] = "Username atau password salah. Silakan coba lagi.";
        $login_success = false;
    }

    // Tutup prepared statement
    $stmt->close();
    $conn->close();
}

if ($login_success) {
    header("Location: index.php"); // Ganti "index.php" dengan halaman yang sesuai
    exit;
} else {
    header("Location: login.php"); // Ganti "login.php" dengan halaman login yang benar
    exit;
}
?>