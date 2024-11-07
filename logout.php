<?php
session_start();
session_destroy(); // Hapus semua data sesi
header("Location: login.html"); // Arahkan kembali ke halaman login
exit();
?>
