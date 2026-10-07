<?php
class Student
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($name, $age, $faculty, $agree_rules, $study_form)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO students (name, age, faculty, agree_rules, study_form) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$name, $age, $faculty, $agree_rules, $study_form]);
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM students ORDER BY id DESC");
        return $stmt->fetchAll();
    }
}
