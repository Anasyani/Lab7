<?php
$host = 'db';
$db   = 'lab7_db';
$user = 'lab7_user';
$pass = 'lab7_pass';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage() . "\n";
    exit(1);
}
