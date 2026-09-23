<?php
require __DIR__ . '/includes/koneksi.php';

echo "<pre>";

echo "Database: " . $pdo->query("SELECT current_database()")->fetchColumn();
echo "\n\n";

echo "Tabel yang ada:\n";

$stmt = $pdo->query("
    SELECT table_name
    FROM information_schema.tables
    WHERE table_schema = 'public'
    ORDER BY table_name
");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "- " . $row['table_name'] . "\n";
}

echo "</pre>";