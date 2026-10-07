<?php
require 'db.php';
require 'Student.php';

$student = new Student($pdo);
$all = $student->getAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация студента</title>
</head>
<body>
    <h1>Регистрация студента</h1>

    <?php if (isset($_GET['sent'])): ?>
        <p style="color:green;">✅ Сообщение отправлено в Kafka! Worker обработает его через пару секунд, обновите страницу.</p>
    <?php endif; ?>

    <h2>Обработанные записи:</h2>
    <ul>
    <?php foreach ($all as $row): ?>
        <li><?= $row['name'] ?>, <?= $row['age'] ?> лет, <?= $row['faculty'] ?>, <?= $row['study_form'] ?>, Согласие: <?= $row['agree_rules'] ? 'Да' : 'Нет' ?> (<?= $row['created_at'] ?>)</li>
    <?php endforeach; ?>
    </ul>
    <?php if (empty($all)): ?>
        <p>Данных пока нет.</p>
    <?php endif; ?>

    <a href="form.html">Заполнить форму</a>
</body>
</html>
