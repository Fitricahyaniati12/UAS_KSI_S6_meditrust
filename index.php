<?php session_start(); ?>
<h1>Selamat Datang di MediTrust</h1>
<p>Sistem Manajemen Rekam Medis Terintegrasi.</p>
<?php if(!isset($_SESSION['user'])): ?>
    <a href="login.php">Klik di sini untuk Login Dokter</a>
<?php else: ?>
    <a href="dashboard.php">Kembali ke Dashboard</a>
<?php endif; ?>