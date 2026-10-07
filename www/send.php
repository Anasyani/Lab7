<?php
require __DIR__ . '/../vendor/autoload.php';
require 'QueueManager.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$name = trim($_POST['name'] ?? '');
if ($name === '') {
    $name = 'Без имени';
}

$q = new QueueManager();
try {
    // Вместо записи в БД отправляем задачу в очередь Kafka
    $q->publish([
        'name' => $name,
        'age' => intval($_POST['age'] ?? 0),
        'faculty' => $_POST['faculty'] ?? '',
        'agree' => isset($_POST['agree']) ? 1 : 0,
        'form' => $_POST['form'] ?? '',
        'timestamp' => date('Y-m-d H:i:s'),
    ]);
} catch (\Throwable $e) {
    echo "Ошибка отправки в Kafka: " . htmlspecialchars($e->getMessage());
    exit();
}

header("Location: index.php?sent=1");
exit();
