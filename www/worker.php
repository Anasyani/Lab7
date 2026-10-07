<?php
require __DIR__ . '/../vendor/autoload.php';
require 'QueueManager.php';
require 'db.php';
require 'Student.php';

$student = new Student($pdo);
$q = new QueueManager();

echo "👷 Рабочий запущен (Kafka)...\n";

$q->consume(function ($data) use ($student) {
    echo "📥 Получено сообщение: " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
    sleep(2); // имитация длительной обработки

    $student->add(
        htmlspecialchars($data['name'] ?? ''),
        intval($data['age'] ?? 0),
        htmlspecialchars($data['faculty'] ?? ''),
        intval($data['agree'] ?? 0),
        htmlspecialchars($data['form'] ?? '')
    );

    file_put_contents(
        __DIR__ . '/processed_kafka.log',
        json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL,
        FILE_APPEND
    );
    echo "✅ Обработано\n";
});
