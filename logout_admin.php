<?php
if (isset($_GET['logout'])) {
    session_destroy(); // Hancurkan sesi
    header("Location: admin_login.php"); // Kembali ke halaman login
    exit();
}
?>
<a href="?logout=true">Logout</a>
