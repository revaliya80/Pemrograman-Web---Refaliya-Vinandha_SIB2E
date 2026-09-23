<?php

require __DIR__ . '/includes/koneksi.php';

$fileJson = __DIR__ . '/../JOBSHEET 6 - PW/data/buku.json';

if (!file_exists($fileJson)) {
    die("File buku.json tidak ditemukan di: " . $fileJson);
}

$data = json_decode(file_get_contents($fileJson), true);

if ($data === null) {
    die("Gagal membaca file JSON.");
}

$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)"
);

foreach ($data as $buku) {
    $stmt->execute([
        'judul' => $buku['judul'],
        'pengarang' => $buku['pengarang'],
        'tahun' => $buku['tahun'],
        'isbn' => $buku['isbn'] ?? null,
        'stok' => $buku['stok'],
        'kategori' => $buku['kategori'] ?? null
    ]);
}

echo "Migrasi data buku berhasil.";