<?php
include 'config/database.php';
include 'config/encryption.php';

echo "<h2>Migrasi Enkripsi NIK</h2>";

$result = $conn->query("SELECT id, nik FROM patients");

if (!$result) {
    die("Query gagal: " . $conn->error);
}

$sukses = 0;
$skip   = 0;

while ($row = $result->fetch_assoc()) {
    $nik = $row['nik'];
    
    // Cek apakah NIK sudah terenkripsi (panjang NIK asli = 16 digit angka)
    if (preg_match('/^\d{16}$/', $nik)) {
        // Masih plaintext → enkripsi
        $nik_enkripsi = enkripsiNIK($nik);
        $stmt = $conn->prepare("UPDATE patients SET nik = ? WHERE id = ?");
        $stmt->bind_param("si", $nik_enkripsi, $row['id']);
        $stmt->execute();
        echo "✅ ID " . $row['id'] . " → NIK berhasil dienkripsi<br>";
        $sukses++;
    } else {
        // Sudah terenkripsi → skip
        echo "⏭️ ID " . $row['id'] . " → NIK sudah terenkripsi, dilewati<br>";
        $skip++;
    }
}

echo "<br><strong>Selesai! Berhasil: $sukses | Dilewati: $skip</strong>";
?>