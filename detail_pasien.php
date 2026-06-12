<?php
include 'config/database.php';
$id = $_GET['id'];
$query = "SELECT * FROM patients WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<h1>Detail Rekam Medis</h1>
<p>Nama: <?php echo $row['name']; ?></p>
<!-- Celah: XSS jika diagnosis mengandung <script>alert('XSS')</script> -->
<p>Diagnosis: <?php echo $row['diagnosis']; ?></p> 

<a href="dashboard.php">Kembali</a>