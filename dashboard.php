ini bagian dasbord
<?php
include 'config/database.php';
include 'includes/header.php';
session_start();

// Celah: Tidak ada pengecekan session yang kuat (header redirection bisa di-bypass)
// Mahasiswa harus menambahkan proteksi isset($_SESSION['user'])
?>

<h2>Dashboard Dokter</h2>
<p>Selamat bekerja, Dokter!</p>

<h3>Daftar Pasien Terbaru:</h3>
<ul>
<?php
$query = "SELECT id, name FROM patients";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)) {
    echo "<li>" . $row['name'] . " - <a href='detail_pasien.php?id=" . $row['id'] . "'>Lihat Detail</a></li>";
}
?>
</ul>

<?php include 'includes/footer.php'; ?>