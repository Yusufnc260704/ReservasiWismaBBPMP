<?php
session_start();
include 'database_connection.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login untuk melakukan booking.";
    exit();
}

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id'];

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi apakah semua data yang diperlukan ada di form
    if (
        empty($_POST['wisma_id']) ||
        empty($_POST['check_in']) ||
        empty($_POST['check_out']) ||
        empty($_POST['room_count']) ||
        empty($_POST['total_price']) ||
        empty($_POST['bank']) ||
        empty($_FILES['payment_proof']['name']) ||
        empty($_POST['name']) ||
        empty($_POST['phone']) ||
        empty($_POST['address'])
    ) {
        die("Silakan isi semua data yang diperlukan.");
    }

    // Data yang diambil dari form
    $wisma_id = $_POST['wisma_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_count = $_POST['room_count'];
    $total_price = $_POST['total_price'];
    $bank = $_POST['bank'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment_proof = $_FILES['payment_proof']['name'];

    // Pindahkan file bukti pembayaran ke folder yang diinginkan
    $upload_dir = "uploads/";
    $target_file = $upload_dir . basename($payment_proof);

    // Upload file bukti pembayaran
    if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $target_file)) {
        // Mulai transaksi
        $conn->begin_transaction();
        
        try {
            // 1. Cek jumlah kamar yang tersedia
            $checkAvailabilityQuery = "SELECT available_rooms FROM wisma WHERE id = ?";
            $stmt = $conn->prepare($checkAvailabilityQuery);
            $stmt->bind_param("i", $wisma_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['available_rooms'] < $room_count) {
                die("Kamar tidak tersedia.");
            }

            // 2. Lakukan insert ke database booking dengan status 'pending'
            $query = "INSERT INTO bookings (user_id, wisma_id, check_in, check_out, room_count, total_price, bank, payment_proof, name, phone, address, status)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";  // 'pending' status
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iississssss", $user_id, $wisma_id, $check_in, $check_out, $room_count, $total_price, $bank, $target_file, $name, $phone, $address);
            $stmt->execute();

            // 3. Commit transaksi
            $conn->commit();

            // Tampilkan pesan bahwa pemesanan berhasil
            echo "Booking berhasil! Menunggu konfirmasi admin.";
            echo '<br><br><a href="halaman.php" class="btn">Kembali ke Halaman Utama</a>';
        } catch (Exception $e) {
            // Rollback jika ada kesalahan
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }

        $stmt->close();
    } else {
        echo "Upload bukti pembayaran gagal.";
    }
} else {
    echo "Form belum disubmit.";
}

$conn->close();
?>
