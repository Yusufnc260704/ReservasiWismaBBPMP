<?php
session_start();
include 'database_connection.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: halaman.php");
    exit();
}

// Ambil semua data booking
$queryBookings = "SELECT b.id, b.user_id, b.wisma_id, b.check_in, b.check_out, b.room_count, b.total_price, u.email, b.bank, b.payment_proof, b.booking_date, b.name, b.phone, b.address, b.status
                  FROM bookings b 
                  JOIN users u ON b.user_id = u.id";
$resultBookings = $conn->query($queryBookings);

// Ambil data wisma
$queryWisma = "SELECT id, nama, total_kamar, available_rooms, harga_per_malam FROM wisma";
$resultWisma = $conn->query($queryWisma);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Booking dan Daftar Wisma</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .logout-btn {
            padding: 10px 20px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }
        .btn-group {
            display: flex;
            gap: 10px;
        }
        .input-field {
            padding: 5px;
            width: 60px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <form method="POST" style="margin-bottom: 20px;">
        <button type="submit" name="logout" class="logout-btn">Logout</button>
    </form>

    <h2>Daftar Booking</h2>
    <table>
        <tr>
            <th>ID Booking</th>
            <th>Email Pengguna</th>
            <th>Wisma ID</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Jumlah Kamar</th>
            <th>Total Harga</th>
            <th>Bank</th>
            <th>Bukti Bayar</th>
            <th>Tanggal Pesan</th>
            <th>Nama</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $resultBookings->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['wisma_id']) ?></td>
                <td><?= htmlspecialchars($row['check_in']) ?></td>
                <td><?= htmlspecialchars($row['check_out']) ?></td>
                <td><?= htmlspecialchars($row['room_count']) ?></td>
                <td><?= number_format($row['total_price'], 2) ?></td>
                <td><?= htmlspecialchars($row['bank']) ?></td>
                <td>
                    <?php if ($row['payment_proof']): ?>
                        <a href="<?= htmlspecialchars($row['payment_proof']) ?>" target="_blank">Lihat Bukti Bayar</a>
                    <?php else: ?>
                        Belum Dikirim
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['booking_date']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td>
                    <?php if ($row['status'] == 'pending'): ?>
                        <form action="process_verifikasi.php" method="POST">
                            <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="verify">Verifikasi</button>
                        </form>
                    <?php else: ?>
                        Terverifikasi
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Daftar Wisma</h2>
<table>
    <tr>
        <th>ID Wisma</th>
        <th>Nama Wisma</th>
        <th>Total Kamar</th>
        <th>Kamar Tersedia</th>
        <th>Harga per Malam</th>
        <th>Aksi</th>
    </tr>
    <?php while ($wisma = $resultWisma->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($wisma['id']) ?></td>
            <td><?= htmlspecialchars($wisma['nama']) ?></td>
            <td><?= htmlspecialchars($wisma['total_kamar']) ?></td>
            <td><?= htmlspecialchars($wisma['available_rooms']) ?></td>
            <td><?= number_format($wisma['harga_per_malam'], 2) ?></td>
            <td>
                <!-- Form untuk mengubah Total Kamar -->
                <form action="process_update_room.php" method="POST" style="display: inline;">
                    <input type="hidden" name="wisma_id" value="<?= $wisma['id'] ?>">
                    <input type="number" name="adjust_rooms" placeholder="Jumlah Total Kamar" min="1" required>
                    <label><input type="radio" name="operation" value="add" required>Tambah</label>
                    <label><input type="radio" name="operation" value="subtract" required>Kurangi</label>
                    <button type="submit" name="update_total_rooms">Ubah Total Kamar</button>
                </form>

                <!-- Form untuk mengubah Kamar Tersedia -->
                <form action="process_update_room.php" method="POST" style="display: inline;">
                    <input type="hidden" name="wisma_id" value="<?= $wisma['id'] ?>">
                    <input type="number" name="adjust_rooms" placeholder="Jumlah Kamar Tersedia" min="1" required>
                    <label><input type="radio" name="operation" value="add" required>Tambah</label>
                    <label><input type="radio" name="operation" value="subtract" required>Kurangi</label>
                    <button type="submit" name="update_available_rooms">Ubah Kamar Tersedia</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</div>
</body>
</html>
