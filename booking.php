<?php
session_start();
include 'database_connection.php';

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $wisma_id = $_POST['wisma_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_count = $_POST['room_count'];

    // Ambil nama wisma dari database
    $query = "SELECT nama, harga_per_malam FROM wisma WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $wisma_id);
    $stmt->execute();
    $stmt->bind_result($wisma_name, $price_per_night);
    $stmt->fetch();
    $stmt->close();

    // Hitung total harga
    $total_price = $price_per_night * $room_count * (strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24); // perhitungan harga berdasarkan jumlah hari

} else {
    echo "Data booking tidak ditemukan. Silakan ulangi pemilihan kamar.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembayaran</title>
    <link rel="stylesheet" href="assets/css/booking.css">
</head>
<body>

<div class="container">
    <h2>Form Pembayaran</h2>

    <form action="process_booking.php" method="POST" enctype="multipart/form-data">
        <!-- Data Hidden -->
        <input type="hidden" name="wisma_id" value="<?= htmlspecialchars($wisma_id) ?>">
        <input type="hidden" name="check_in" value="<?= htmlspecialchars($check_in) ?>">
        <input type="hidden" name="check_out" value="<?= htmlspecialchars($check_out) ?>">
        <input type="hidden" name="room_count" value="<?= htmlspecialchars($room_count) ?>">
        <input type="hidden" name="total_price" value="<?= htmlspecialchars($total_price) ?>">

        <!-- Informasi Wisma -->
        <p><strong>Wisma:</strong> <?= htmlspecialchars($wisma_name) ?></p>
        <p><strong>Tanggal Check-in:</strong> <?= htmlspecialchars($check_in) ?></p>
        <p><strong>Tanggal Check-out:</strong> <?= htmlspecialchars($check_out) ?></p>
        <p><strong>Jumlah Kamar:</strong> <?= htmlspecialchars($room_count) ?></p>
        <p><strong>Total Harga (IDR):</strong> Rp<?= number_format($total_price, 0, ',', '.') ?></p>

        <!-- Informasi Form -->
        <label for="name">Nama:</label>
        <input type="text" name="name" required>

        <label for="phone">No Telepon:</label>
        <input type="text" name="phone" required>

        <label for="address">Alamat:</label>
        <input type="text" name="address" required>

        <!-- Pilih Bank -->
        <label for="bank">Pilih Bank:</label>
        <select id="bank-select" name="bank" required onchange="updateBankDetails()">
            <option value="">Pilih Bank</option>
            <option value="Bank BRI">Bank BRI</option>
            <option value="Bank BNI">Bank BNI</option>
            <option value="Bank BCA">Bank BCA</option>
            <option value="Bank MANDIRI">Bank MANDIRI</option>
        </select>

        <!-- Rincian Bank -->
        <div class="bank-details">
            <p><strong>BANK:</strong> <span id="account-name">-</span></p>
            <p><strong>Nomor Rekening:</strong> <span id="account-number">-</span></p>
        </div>

        <!-- Upload Bukti Pembayaran -->
        <label for="payment_proof">Upload Bukti Pembayaran:</label>
        <input type="file" name="payment_proof" accept="image/*" required>

        <button type="submit">Konfirmasi Pembayaran</button>
    </form>
</div>

<script>
function updateBankDetails() {
    const bankSelect = document.getElementById("bank-select");
    const accountName = document.getElementById("account-name");
    const accountNumber = document.getElementById("account-number");

    const bankDetails = {
        "Bank BRI": { name: "Bank BRI", number: "1234567890" },
        "Bank BNI": { name: "Bank BNI", number: "0987654321" },
        "Bank BCA": { name: "Bank BCA", number: "1122334455" },
        "Bank MANDIRI": { name: "Bank MANDIRI", number: "1122334455" },
    };

    if (bankSelect.value && bankDetails[bankSelect.value]) {
        accountName.textContent = bankDetails[bankSelect.value].name;
        accountNumber.textContent = bankDetails[bankSelect.value].number;
    } else {
        accountName.textContent = "-";
        accountNumber.textContent = "-";
    }
}
</script>

</body>
</html>
