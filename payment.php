<?php
session_start();
include 'database_connection.php';

$wisma_id = $_POST['wisma_id'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$room_count = $_POST['room_count'];
$total_price = $_POST['total_price'];
$bank = $_POST['bank'];
$user_id = $_SESSION['user_id'];

// Unggah bukti pembayaran
$payment_proof = $_FILES['payment_proof'];
$proof_path = "uploads/" . basename($payment_proof['name']);
move_uploaded_file($payment_proof['tmp_name'], $proof_path);

// Simpan data booking
$query = "INSERT INTO bookings (user_id, wisma_id, check_in, check_out, room_count, total_price, bank, payment_proof) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iissidss", $user_id, $wisma_id, $check_in, $check_out, $room_count, $total_price, $bank, $proof_path);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Booking berhasil! Anda akan diarahkan ke halaman utama.";
    header("Location: halaman.php");
} else {
    echo "Gagal melakukan booking. Silakan coba lagi.";
}

$stmt->close();
$conn->close();
?>
