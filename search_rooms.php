<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Silakan login terlebih dahulu untuk melakukan pencarian kamar.";
    exit();
}

// Mendapatkan data check-in, check-out, dan jumlah kamar dari formulir sebelumnya
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$room_count = $_POST['room_count'];

// Koneksi ke database
$host = 'localhost'; // Ganti dengan host database Anda
$db = 'wisma_bbpmp'; // Nama database
$user = 'root'; // Username default untuk XAMPP
$pass = ''; // Password default untuk XAMPP (kosongkan jika tidak ada)

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data wisma dari database
$sql = "SELECT id, nama, harga_per_malam, available_rooms FROM wisma";
$result = $conn->query($sql);

$available_rooms = [];

// Array untuk menyimpan gambar berdasarkan ID wisma
$gambar_wisma = [
    1 => 'assets/img/kartini1.jpg',
    2 => 'assets/img/meutia1.jpg',
    3 => 'assets/img/rasuna1.jpg',
    4 => 'assets/img/sartika1.jpg',
    5 => 'assets/img/dien1.jpg',
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $available_rooms[] = [
            'id' => $row['id'],
            'nama' => $row['nama'],
            'harga_per_malam' => $row['harga_per_malam'],
            'available_rooms' => $row['available_rooms'],
            'gambar' => $gambar_wisma[$row['id']]
        ];
    }
} else {
    echo "Tidak ada data wisma yang tersedia.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pencarian Kamar</title>
    <link rel="stylesheet" href="assets/css/search_rooms.css">
</head>
<body>
    <h2>Kamar Wisma Tersedia</h2>
    <form action="booking.php" method="POST">
        <!-- Mengirim data check-in, check-out, dan room_count ke booking.php -->
        <input type="hidden" name="check_in" value="<?= htmlspecialchars($check_in) ?>">
        <input type="hidden" name="check_out" value="<?= htmlspecialchars($check_out) ?>">
        <input type="hidden" name="room_count" value="<?= htmlspecialchars($room_count) ?>">
        
        <div class="card-container">
            <?php foreach ($available_rooms as $wisma): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($wisma['gambar']) ?>" alt="<?= htmlspecialchars($wisma['nama']) ?>">
                    <div class="card-content">
                        <h3><?= htmlspecialchars($wisma['nama']) ?></h3>
                        <p>Rp<?= number_format($wisma['harga_per_malam'], 0, ',', '.') ?>/malam</p>
                        <p>Jumlah Kamar Tersedia: <?= htmlspecialchars($wisma['available_rooms']) ?></p>
                        <button type="submit" name="wisma_id" value="<?= $wisma['id'] ?>">Pilih Wisma</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </form>
</body>
</html>
