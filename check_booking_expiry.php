<?php
include 'database_connection.php';

// Ambil semua booking yang sudah di-activate dan masa berlakunya sudah habis
$queryExpiredBookings = "SELECT b.id, b.room_count, b.wisma_id 
                         FROM bookings b 
                         JOIN masa_berlaku m ON b.id = m.booking_id 
                         WHERE m.status = 'active' AND b.check_out < NOW()";
$resultExpired = $conn->query($queryExpiredBookings);

while ($row = $resultExpired->fetch_assoc()) {
    $booking_id = $row['id'];
    $room_count = $row['room_count'];
    $wisma_id = $row['wisma_id'];

    // Kembalikan kamar yang telah habis masa berlakunya
    $updateRoomsQuery = "UPDATE wisma SET available_rooms = available_rooms + ? WHERE id = ?";
    $stmt = $conn->prepare($updateRoomsQuery);
    $stmt->bind_param("ii", $room_count, $wisma_id);
    $stmt->execute();
    $stmt->close();

    // Update status masa berlaku menjadi expired
    $updateMasaBerlakuQuery = "UPDATE masa_berlaku SET status = 'expired' WHERE booking_id = ?";
    $stmt = $conn->prepare($updateMasaBerlakuQuery);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->close();
}
?>
