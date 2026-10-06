<?php
session_start();
require 'db.php';
require 'functions.php';

// GET reads the task ID from the Edit link in index.php.
$id = (int) ($_GET['id'] ?? 0);
$statement = $pdo->prepare('SELECT * FROM tasks WHERE id = :id');
$statement->execute(['id' => $id]);
$task = $statement->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    exit('Task not found.');
}

$pageTitle = 'Edit task';
$errors = [];

// Fill the form with the task already saved in MySQL.
$values = [
    'title' => $task['title'],
    'description' => $task['description'],
    'category' => $task['category'],
    'priority' => $task['priority'],
    'due_date' => $task['due_date'] ?? '',
    'completed' => (int) $task['completed'],
];

// POST means the user submitted the edited form.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values = [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'category' => trim($_POST['category'] ?? ''),
        'priority' => $_POST['priority'] ?? 'Medium',
        'due_date' => $_POST['due_date'] ?? '',
        'completed' => isset($_POST['completed']) ? 1 : 0,
    ];

    if ($values['title'] === '') {
        $errors[] = 'Please enter a title.';
    }

    if (!in_array($values['priority'], ['Low', 'Medium', 'High'], true)) {
        $errors[] = 'Please choose a valid priority.';
    }

    // Save the changes only when the form is valid.
    if (empty($errors)) {
        $sql = 'UPDATE tasks SET title = :title, description = :description,
                category = :category, priority = :priority, due_date = :due_date,
                completed = :completed WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'title' => $values['title'],
            'description' => $values['description'],
            'category' => $values['category'],
            'priority' => $values['priority'],
            'due_date' => $values['due_date'] === '' ? null : $values['due_date'],
            'completed' => $values['completed'],
            'id' => $id,
        ]);

        $_SESSION['message'] = 'Task updated.';
        header('Location: index.php');
        exit;
    }
}

// Use the shared form to display the task and any validation errors.
require 'task_form.php';
