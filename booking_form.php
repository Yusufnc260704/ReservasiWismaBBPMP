<?php
session_start();  // Memulai sesi

if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login untuk melanjutkan ke formulir booking.";
    exit();
}

$wisma_id = $_GET['wisma_id'];
$check_in = $_GET['check_in'];
$check_out = $_GET['check_out'];
$room_count = $_GET['room_count'];
?>

<h2>Formulir Booking</h2>
<form action="process_booking.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="wisma_id" value="<?php echo $wisma_id; ?>">
    <input type="hidden" name="check_in" value="<?php echo $check_in; ?>">
    <input type="hidden" name="check_out" value="<?php echo $check_out; ?>">
    <input type="hidden" name="room_count" value="<?php echo $room_count; ?>">
    
    <label>Nama Lengkap:</label>
    <input type="text" name="name" required>
    
    <label>Nomor Telepon:</label>
    <input type="text" name="phone" required>
    
    <label>Metode Pembayaran:</label>
    <select name="payment_method" required>
        <option value="Bank A">Bank A</option>
        <option value="Bank B">Bank B</option>
    </select>
    
    <label>Upload Bukti Pembayaran:</label>
    <input type="file" name="proof_of_payment" required>

    <button type="submit">Konfirmasi Booking</button>
</form>
