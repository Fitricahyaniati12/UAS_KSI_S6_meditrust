<?php
session_start();
include 'config/database.php';
include 'config/encryption.php';

// Cek session
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cari Pasien</title>
</head>
<body>

<!-- Form Pencarian -->
<h1>Pencarian Pasien</h1>
<form method="GET" action="search.php">
    <input 
        type="text" 
        name="q" 
        placeholder="Masukkan nama pasien..." 
        value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>"
    >
    <button type="submit">Cari</button>
</form>

<hr>

<?php
// Proses pencarian hanya jika ada input
if (isset($_GET['q']) && trim($_GET['q']) !== '') {

    $keyword = trim($_GET['q']);
    $name    = '%' . $keyword . '%';

    // Debug sementara — hapus setelah berhasil
    echo "<small><i>Debug: mencari keyword = <b>" . htmlspecialchars($keyword) . "</b></i></small><br><br>";

    // Prepared statement
    $stmt = $conn->prepare("SELECT * FROM patients WHERE name LIKE ?");

    if (!$stmt) {
        die("Prepare gagal: " . $conn->error);
    }

    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    // Debug jumlah hasil — hapus setelah berhasil
    echo "<small><i>Debug: ditemukan " . $result->num_rows . " data</i></small><br><br>";

    if ($result->num_rows === 0) {
        echo "<p>Pasien dengan nama <strong>" . htmlspecialchars($keyword) . "</strong> tidak ditemukan.</p>";
    } else {
        echo "<h2>Hasil Pencarian:</h2>";
        echo "<table border='1' cellpadding='8'>";
        echo "<tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Diagnosis</th>
                <th>Tanggal</th>
                <th>Aksi</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id'])                        . "</td>";
            echo "<td>" . htmlspecialchars($row['name'])                      . "</td>";
            echo "<td>" . htmlspecialchars(dekripsiNIK($row['nik']))          . "</td>";
            echo "<td>" . htmlspecialchars($row['diagnosis'])                 . "</td>";
            echo "<td>" . htmlspecialchars($row['created_at'])                . "</td>";
            echo "<td><a href='detail_pasien.php?id=" . $row['id'] . "'>Detail</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    }

} else {
    echo "<p>Silakan masukkan nama pasien untuk mencari.</p>";
}
?>

<form action="dashboard.php" method="get">
    <button type="submit">Kembali ke Dashboard</button>
</form>