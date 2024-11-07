<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking - Wisma BBPMP Jateng</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<header>
<nav>
    <div class="logo">Reservasi Wisma BBPMP Jateng</div>
    <input type="checkbox" id="menu-toggle" />
    <label for="menu-toggle" class="menu-icon"><i class=""></i></label>
    <ul class="menu">
        <li><a href="#Info">Info</a></li>
        <li><a href="kontak.html">Kontak</a></li>
        <?php
        session_start();
        if (isset($_SESSION['username'])) {
            echo '<li><a href="profile.php">Profil</a></li>';
            echo '<li><a href="logout.php" class="register-btn">Logout</a></li>';
        } else {
            echo '<li><a href="login.html" class="register-btn">Login</a></li>';
        }
        ?>
    </ul>
</nav>

</header>

<main>
    <section id="headline">
        <div class="headline-container">
            <img src="assets/img/BBPMP1.jpg" alt="Berita Utama" class="headline-image" />
            <div class="headline-content">
                <h1>PESAN KAMAR ONLINE DENGAN MUDAH!</h1>
                <p>PESAN KAMARMU SEKARANG!</p>
                <div class="booking-section">
                    <a href="cari_kamar.php" class="booking-btn-custom">Booking Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <sion id="tengah">
        <h2>DAFTAR WISMA BBPMP JATENG</h2>
        <div class="news-grid">
            <!-- Berita akan ditambahkan di sini secara dinamis menggunakan JavaScript -->
        </div>
    </section>

    <section class="payment-section">
        <div class="payment-title">
            <h2>Payment</h2>
        </div>
        <div class="bank-logos">
            <img src="assets/img/bankbri.png" alt="Logo Bank 1" />
            <img src="assets/img/bankbni.png" alt="Logo Bank 2" />
            <img src="assets/img/bankmandiri.png" alt="Logo Bank 3" />
            <img src="assets/img/bankbca.png" alt="Logo Bank 4" />
        </div>
    </section>

    <section class="gambar-kalimat">
        <div class="gambar">
            <img src="assets/img/bahan3.png" alt="Gambar" />
        </div>
        <div class="kalimat">
            <p>
                Booking penginapan kini menjadi lebih mudah dengan website kami! Temukan berbagai pilihan wisma yang nyaman dan sesuai kebutuhan Anda hanya dalam beberapa klik. Dengan antarmuka yang ramah pengguna dan fitur “Booking Sekarang”
                yang cepat, proses pemesanan menjadi lebih praktis dan aman.
            </p>
        </div>
    </section>
</main>

<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h3>Tentang Kami</h3>
            <p>Balai Besar Penjaminan Mutu Pendidikan. Jl. Kyai Mojo, Srondol Kulon, Kec. Banyumanik, Kota Semarang, Jawa Tengah 50263</p>
        </div>
        <div class="footer-section">
            <h3>Hubungi Kami</h3>
            <p>Email: info@bbpmpjateng.com</p>
            <p>Telepon: (021) 1234-5678</p>
        </div>
        <div class="footer-section">
            <h3></h3>
            <div class="social-icons">
                <ul>
                    <li>
                        <a href="https://www.facebook.com/groups/78771971730"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fab fa-google-plus-g" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/c/LPMPJATENGOFFICIAL"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/bbpmpjateng/?hl=id"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="maps-section">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.651701746915!2d110.40813137403762!3d-7.0501507690829195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708be5ab2efc47%3A0x1fb79229e485c61f!2sBalai%20Besar%20Penjaminan%20Mutu%20Pendidikan%20(BBPMP)%20Provinsi%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1727336487994!5m2!1sid!2sid"
                width="600"
                height="450"
                style="border: 0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 BBPMP Jateng. Hak Cipta Dilindungi.</p>
    </div>
</footer>
<script src="assets/js/script.js" defer></script>
</body>
</html>
