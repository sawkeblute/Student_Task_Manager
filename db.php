<?php
// Database settings. The supplied schema creates this database.
$host = 'localhost';
$database = 'student_task_manager';
$username = 'root';
$password = '';

// PDO is PHP's connection to the MySQL database.
$pdo = new PDO(
    "mysql:host=$host;dbname=$database;charset=utf8mb4",
    $username,
    $password,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
