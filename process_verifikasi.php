<?php
session_start();
include 'database_connection.php';

// Cek apakah ada permintaan POST dan booking_id yang diberikan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify'])) {
    $booking_id = $_POST['booking_id'];

    // Validasi booking_id
    if (empty($booking_id)) {
        echo "ID booking tidak valid.";
        exit();
    }

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // 1. Update status booking menjadi 'confirmed'
        $updateBookingQuery = "UPDATE bookings SET status = 'confirmed' WHERE id = ?";
        $stmt = $conn->prepare($updateBookingQuery);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        
        if ($stmt->affected_rows === 0) {
            throw new Exception("Booking tidak ditemukan atau sudah terverifikasi.");
        }

        // 2. Update jumlah kamar di wisma
        $getBookingQuery = "SELECT wisma_id, room_count FROM bookings WHERE id = ?";
        $stmt = $conn->prepare($getBookingQuery);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();

        $wisma_id = $booking['wisma_id'];
        $room_count = $booking['room_count'];

        // Update jumlah kamar yang tersedia
        $updateRoomsQuery = "UPDATE wisma SET available_rooms = available_rooms - ? WHERE id = ?";
        $stmt = $conn->prepare($updateRoomsQuery);
        $stmt->bind_param("ii", $room_count, $wisma_id);
        $stmt->execute();

        // 3. Tambahkan entri baru ke tabel masa_berlaku
        $insertMasaBerlakuQuery = "INSERT INTO masa_berlaku (booking_id, status) VALUES (?, 'active')";
        $stmt = $conn->prepare($insertMasaBerlakuQuery);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        
        // Commit transaksi
        $conn->commit();

        // Redirect kembali ke halaman daftar booking
        header("Location: admin_dashboard.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Permintaan tidak valid.";
}
?>
