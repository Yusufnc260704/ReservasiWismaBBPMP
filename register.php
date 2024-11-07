<?php
// Hubungkan ke database
$host = 'localhost'; // Nama host XAMPP
$db = 'wisma_bbpmp'; // Nama database
$user = 'root'; // Nama user default di XAMPP
$pass = ''; // Biasanya password kosong di XAMPP

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses pendaftaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman login setelah berhasil daftar
        header("Location: login.html"); // Pastikan ini sesuai dengan nama file login kamu
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
