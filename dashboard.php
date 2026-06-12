<?php
session_start(); // session_start() HARUS dipanggil PERTAMA sebelum include apapun
include 'config/database.php';
include 'includes/header.php';

// Pengecekan session - jika belum login, lempar ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit(); // exit() wajib ada agar kode di bawah tidak ikut dieksekusi
}
?>

<h2>Dashboard Dokter</h2>
<p>Selamat bekerja, Dokter <?php echo htmlspecialchars($_SESSION['user']); ?>!</p>

<h3>Daftar Pasien Terbaru:</h3>
<ul>
<?php
$query = "SELECT id, name FROM patients";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)) {
    echo "<li>" 
        . htmlspecialchars($row['name']) 
        . " - <a href='detail_pasien.php?id=" . (int)$row['id'] . "'>Lihat Detail</a></li>";
}
?>
</ul>

<?php include 'includes/footer.php'; ?>