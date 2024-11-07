<?php
session_start();  // Memulai sesi untuk memastikan apakah pengguna sudah login

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pencarian Kamar</title>
    <link rel="stylesheet" href="assets/css/cari_kamar.css">
</head>
<body>
    <!-- Formulir Pencarian Kamar -->
    <form action="search_rooms.php" method="POST">
        <label>Check-in:</label>
        <input type="date" name="check_in" required>
        
        <label>Check-out:</label>
        <input type="date" name="check_out" required>
        
        <label>Jumlah Kamar:</label>
        <input type="number" name="room_count" placeholder="Jumlah Kamar" required>
        
        <button type="submit">Cari Kamar</button>
    </form>
</body>
</html>
