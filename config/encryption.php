<?php
define('ENCRYPTION_KEY', 'kunci-rahasia-32-karakter-aman!!');
define('ENCRYPTION_IV',  '1234567890123456');

function enkripsiNIK($nik) {
    return base64_encode(openssl_encrypt(
        $nik,
        'AES-256-CBC',
        ENCRYPTION_KEY,
        0,
        ENCRYPTION_IV
    ));
}

function dekripsiNIK($nik_terenkripsi) {
    $decoded = base64_decode($nik_terenkripsi, true);
    if ($decoded === false) return $nik_terenkripsi; // fallback plaintext
    
    $result = openssl_decrypt(
        $decoded,
        'AES-256-CBC',
        ENCRYPTION_KEY,
        0,
        ENCRYPTION_IV
    );
    return $result !== false ? $result : $nik_terenkripsi; // fallback plaintext
}
?>