# Лабораторная работа №7: Очереди сообщений (Kafka)

## 👩‍💻 Автор

ФИО: Янина Анастасия Алексеевна  
Группа: 2
Вариант: 1 

---

## 📌 Описание задания

Реализовать асинхронную обработку данных через очередь сообщений: форма отправляет данные в Kafka (producer), а отдельный процесс worker (consumer) получает сообщения и сохраняет их в MySQL.

---

## ⚙️ Как запустить проект

```
git clone <ссылка на репозиторий>
cd lab7
docker-compose up -d --build
```

- Сайт: `http://localhost:8080`
- Форма: `http://localhost:8080/form.html`

Worker запускается автоматически отдельным сервисом `worker`. Логи обработки:

```
docker logs -f lab7_worker
```

Либо вручную: `docker exec -it lab7_php php worker.php`.

Kafka и MySQL стартуют около минуты. Пока они не готовы, worker перезапускается сам, а сайт может показывать «Ошибка подключения»: нужно немного подождать.

---

## 📂 Содержимое проекта

- `docker-compose.yml` — сервисы `php`, `worker`, `zookeeper`, `kafka`, `db` (MySQL), `nginx`
- `Dockerfile` — PHP-FPM, Composer, установка зависимостей
- `composer.json` — `nmred/kafka-php`, `php-amqplib/php-amqplib`
- `nginx.conf` — конфиг Nginx с PHP-FPM
- `db/init.sql` — таблица `students`
- `www/QueueManager.php` — класс для работы с Kafka (`publish`, `consume`)
- `www/send.php` — producer: отправляет данные формы в топик `lab7_topic`
- `www/worker.php` — consumer: получает сообщения и сохраняет в БД и в `processed_kafka.log`
- `www/db.php`, `www/Student.php` — подключение к MySQL и класс для таблицы
- `www/form.html`, `www/index.php` — форма и вывод обработанных записей

---

## 🧪 Ход работы

1. **Docker.** В `docker-compose.yml` добавлены Zookeeper и Kafka, а также MySQL и сервис `worker`.
2. **Зависимости.** Через Composer установлена библиотека `nmred/kafka-php`.
3. **Producer.** `send.php` вместо записи в БД публикует сообщение с данными формы в топик `lab7_topic` и перенаправляет на главную.
4. **Consumer.** `worker.php` читает топик, имитирует долгую обработку (`sleep(2)`), сохраняет запись в MySQL и пишет в `processed_kafka.log`.
5. **Проверка.** После отправки формы запись появляется на главной не сразу, а после обработки worker’ом.

---

## ✅ Результат

Данные формы обрабатываются асинхронно: сайт мгновенно отправляет сообщение в Kafka, а worker отдельно сохраняет его в базу данных.
