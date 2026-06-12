<?php
session_start();
include 'config/database.php';
include 'config/encryption.php';

// Cek session
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Validasi ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die("ID tidak valid.");
}

// Query dengan prepared statement
$stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row    = $result->fetch_assoc();

if (!$row) {
    die("Data pasien tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pasien</title>
</head>
<body>

<h1>Detail Rekam Medis</h1>

<table border="1" cellpadding="8">
    <tr>
        <td><strong>ID</strong></td>
        <td><?php echo htmlspecialchars($row['id']); ?></td>
    </tr>
    <tr>
        <td><strong>Nama</strong></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
    </tr>
    <tr>
        <td><strong>NIK</strong></td>
        <td><?php echo htmlspecialchars(dekripsiNIK($row['nik'])); ?></td>
    </tr>
    <tr>
        <td><strong>Diagnosis</strong></td>
        <td><?php echo htmlspecialchars($row['diagnosis']); ?></td>
    </tr>
    <tr>
        <td><strong>Tanggal</strong></td>
        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
    </tr>
</table>

<br>
<a href="dashboard.php">← Kembali ke Dashboard</a>

</body>
</html>