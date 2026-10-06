<?php
session_start();
require 'db.php';

// The delete form sends the task ID with POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);

    $statement = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
    $statement->execute(['id' => $id]);

    $_SESSION['message'] = 'Task deleted.';
}

// Return to the list after deleting.
header('Location: index.php');
exit;
