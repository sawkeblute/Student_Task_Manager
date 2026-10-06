<?php
session_start();
require 'db.php';

// The check button sends the task ID and the new status with POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    $completed = (int) ($_POST['completed'] ?? 0);

    if ($id > 0 && ($completed === 0 || $completed === 1)) {
        $sql = 'UPDATE tasks SET completed = :completed WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'completed' => $completed,
            'id' => $id,
        ]);

        if ($completed === 1) {
            $_SESSION['message'] = 'Task marked completed.';
        } else {
            $_SESSION['message'] = 'Task marked in progress.';
        }
    }
}

header('Location: index.php');
exit;
