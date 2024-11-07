<?php
session_start();
include 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($email && $password) {
        // Email khusus admin
        $adminEmail = "adminbbpmpit2024@gmail.com"; // Ganti dengan email admin yang sebenarnya

        if ($email === $adminEmail) {
            // Proses login untuk admin
            $query = "SELECT * FROM admins WHERE username = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $admin = $result->fetch_assoc();

                // Verifikasi password (tanpa hash, sesuaikan jika perlu)
                if ($password === $admin['password']) {
                    $_SESSION['admin_logged_in'] = true;
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    echo "Password admin salah!";
                }
            } else {
                echo "Email admin tidak ditemukan!";
            }
        } else {
            // Proses login untuk user
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Verifikasi password (dengan hash)
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: halaman.php");
                    exit();
                } else {
                    echo "Password user salah!";
                }
            } else {
                echo "Email tidak ditemukan!";
            }
        }

        // Tutup statement jika ada
        if (isset($stmt)) {
            $stmt->close();
        }
    } else {
        echo "Silakan isi semua data yang diperlukan.";
    }
}

$conn->close();
?>
