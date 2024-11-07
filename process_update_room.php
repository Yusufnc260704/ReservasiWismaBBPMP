<?php
session_start();
include 'database_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $wismaId = $_POST['wisma_id'];
    $adjustRooms = $_POST['adjust_rooms'];
    $operation = $_POST['operation'];

    // Proses untuk menambah/mengurangi Total Kamar
    if (isset($_POST['update_total_rooms'])) {
        $query = $operation === 'add' 
            ? "UPDATE wisma SET total_kamar = total_kamar + ? WHERE id = ?"
            : "UPDATE wisma SET total_kamar = total_kamar - ? WHERE id = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $adjustRooms, $wismaId);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Total kamar berhasil diperbarui.";
        } else {
            $_SESSION['message'] = "Gagal memperbarui total kamar.";
        }
        $stmt->close();
    }
    
    // Proses untuk menambah/mengurangi Kamar Tersedia
    elseif (isset($_POST['update_available_rooms'])) {
        $query = $operation === 'add' 
            ? "UPDATE wisma SET available_rooms = available_rooms + ? WHERE id = ?"
            : "UPDATE wisma SET available_rooms = available_rooms - ? WHERE id = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $adjustRooms, $wismaId);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Kamar tersedia berhasil diperbarui.";
        } else {
            $_SESSION['message'] = "Gagal memperbarui kamar tersedia.";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Perintah tidak dikenali.";
    }

    // Redirect kembali ke halaman admin setelah memperbarui
    header("Location: admin_dashboard.php");
    exit();
}
?>
