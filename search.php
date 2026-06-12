<?php
include 'config/database.php';

$name = $_GET['q']; // Celah: Input langsung digunakan tanpa Prepared Statements

// Vektor Serangan: ' OR '1'='1
$query = "SELECT * FROM patients WHERE name LIKE '%$name%'";
$result = mysqli_query($conn, $query);

echo "<h1>Hasil Pencarian Pasien:</h1>";
while($row = mysqli_fetch_assoc($result)) {
    echo "Nama: " . $row['name'] . " | NIK: " . $row['nik'] . "<br>";
}
?>