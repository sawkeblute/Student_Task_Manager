<?php
session_start();
require 'db.php';
require 'functions.php';

$pageTitle = 'Add a task';
$errors = [];

// These values keep the form empty the first time it opens.
$values = [
    'title' => '',
    'description' => '',
    'category' => '',
    'priority' => 'Medium',
    'due_date' => '',
];

// The form sends its information with POST when Save is clicked.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values = [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'category' => trim($_POST['category'] ?? ''),
        'priority' => $_POST['priority'] ?? 'Medium',
        'due_date' => $_POST['due_date'] ?? '',
    ];

    // Check required and allowed values before writing to the database.
    if ($values['title'] === '') {
        $errors[] = 'Please enter a title.';
    }

    if (!in_array($values['priority'], ['Low', 'Medium', 'High'], true)) {
        $errors[] = 'Please choose a valid priority.';
    }

    // Only save when there are no errors.
    if (empty($errors)) {
        $sql = 'INSERT INTO tasks (title, description, category, priority, due_date)
                VALUES (:title, :description, :category, :priority, :due_date)';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'title' => $values['title'],
            'description' => $values['description'],
            'category' => $values['category'],
            'priority' => $values['priority'],
            'due_date' => $values['due_date'] === '' ? null : $values['due_date'],
        ]);

        // Show a message after returning to the task list.
        $_SESSION['message'] = 'Task added.';
        header('Location: index.php');
        exit;
    }
}

// Show the same form used by the Edit page.
require 'task_form.php';
