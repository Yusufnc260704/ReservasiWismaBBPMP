<?php
session_start();
include 'database_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika pengguna belum login
    exit;
}

$booking_id = $_GET['booking_id'];

// Ambil detail booking dari database
$sql = "SELECT * FROM bookings WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();

    // Buat konten tiket
    $ticket_content = "Tiket Booking\n";
    $ticket_content .= "Wisma ID: " . $booking['wisma_id'] . "\n";
    $ticket_content .= "Check-in: " . $booking['check_in'] . "\n";
    $ticket_content .= "Check-out: " . $booking['check_out'] . "\n";
    $ticket_content .= "Jumlah Kamar: " . $booking['room_count'] . "\n";
    $ticket_content .= "Bank: " . $booking['bank'] . "\n";
    $ticket_content .= "Bukti Pembayaran: " . $booking['payment_proof'] . "\n";

    // Set header untuk unduh
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="ticket_' . $booking_id . '.txt"');

    echo $ticket_content;
} else {
    echo "Tiket tidak ditemukan.";
}
?>
