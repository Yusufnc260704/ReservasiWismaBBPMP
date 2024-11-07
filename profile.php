<?php
session_start();
require 'database_connection.php'; // Pastikan Anda menghubungkan ke database

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data dari tabel bookings
$stmt = $conn->prepare("SELECT name, phone, address FROM bookings WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Ambil data
if ($result->num_rows > 0) {
    $user_info = $result->fetch_assoc();
} else {
    $user_info = null;
}

// Ambil riwayat booking
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$history = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Pengguna</title>
</head>
<body>
    <h1>Profil Pengguna</h1>

    <p>Pesanan kamar anda akan di konfirmasi dalam wakrtu 1x24 jam.</p>

    <h2>Riwayat Booking</h2>
    <table border="1">
        <tr>
            <th>ID Booking</th>
            <th>Wisma</th>
            <th>Tanggal Check-in</th>
            <th>Tanggal Check-out</th>
            <th>Status</th>
            <th>Tanggal Pesan</th>
            <th>Nama</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Status Aktif</th> <!-- Kolom tambahan untuk status aktif -->
        </tr>
        <?php 
        while ($booking = $history->fetch_assoc()): 
            // Menghitung status aktif
            $current_date = date('Y-m-d'); // Mendapatkan tanggal saat ini
            $is_active = ($current_date <= $booking['check_out']) ? 'Aktif' : 'Tidak Aktif'; // Menentukan status aktif
        ?>
            <tr>
                <td><?php echo htmlspecialchars($booking['id']); ?></td>
                <td><?php echo htmlspecialchars($booking['wisma_id']); ?></td>
                <td><?php echo htmlspecialchars($booking['check_in']); ?></td>
                <td><?php echo htmlspecialchars($booking['check_out']); ?></td>
                <td><?php echo htmlspecialchars($booking['status']); ?></td>
                <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                <td><?php echo htmlspecialchars($booking['name']); ?></td>
                <td><?php echo htmlspecialchars($booking['phone']); ?></td>
                <td><?php echo htmlspecialchars($booking['address']); ?></td>
                <td><?php echo htmlspecialchars($is_active); ?></td> <!-- Menampilkan status aktif -->
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
