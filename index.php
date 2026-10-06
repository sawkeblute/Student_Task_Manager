<?php
session_start();
require 'db.php';
require 'functions.php';

// Read the saved tasks and calculate the dashboard numbers.
$tasks = $pdo->query('SELECT * FROM tasks ORDER BY due_date ASC')->fetchAll(PDO::FETCH_ASSOC);
$completed = (int) $pdo->query('SELECT COUNT(*) FROM tasks WHERE completed = 1')->fetchColumn();
$pending = count($tasks) - $completed;

// Read and then clear the one-time message from the last action.
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app-shell">
    <header class="topbar">
        <a class="brand" href="index.php">
            <span class="brand-mark">S</span>
            <span>Study<span class="brand-light">Desk</span></span>
        </a>
        <div class="student-chip">
            <span class="student-dot"></span>
            Saw Ke Blute <span class="chip-divider"></span> 202300154
        </div>
    </header>

    <main class="dashboard">
        <section class="welcome-panel">
            <div class="welcome-copy">
                <p class="eyebrow">YOUR PERSONAL STUDY SPACE</p>
                <h1>Make room for<br><span>what matters.</span></h1>
                <p class="welcome-text">A little progress each day adds up. Keep your coursework clear, calm, and moving forward.</p>
                <a class="button button-light" href="create.php">
                    <span class="plus">＋</span> Add a task
                </a>
            </div>
            <div class="welcome-art" aria-hidden="true">
                <div class="art-orbit orbit-one"></div>
                <div class="art-orbit orbit-two"></div>
                <div class="art-note">
                    <span class="note-check">✓</span>
                    <span class="note-lines"><i></i><i></i><i></i></span>
                </div>
                <div class="art-star">✦</div>
            </div>
        </section>

        <?php if ($message !== ''): ?>
            <p class="message" role="status">
                <span class="message-check">✓</span><?= e($message) ?>
            </p>
        <?php endif; ?>

        <section class="overview" aria-label="Task overview">
            <div class="section-heading">
                <div>
                    <p class="eyebrow dark-eyebrow">AT A GLANCE</p>
                    <h2>Your progress</h2>
                </div>
                <span class="today-label">Keep going, one task at a time</span>
            </div>

            <div class="stats-grid">
                <article class="stat-card total-stat">
                    <span class="stat-icon">▤</span>
                    <div><p>Total tasks</p><strong><?= count($tasks) ?></strong></div>
                    <span class="stat-caption">on your list</span>
                </article>
                <article class="stat-card pending-stat">
                    <span class="stat-icon">◷</span>
                    <div><p>In progress</p><strong><?= $pending ?></strong></div>
                    <span class="stat-caption">ready for you</span>
                </article>
                <article class="stat-card done-stat">
                    <span class="stat-icon">✓</span>
                    <div><p>Completed</p><strong><?= $completed ?></strong></div>
                    <span class="stat-caption">nice work</span>
                </article>
            </div>
        </section>

        <section class="tasks-section">
            <div class="section-heading task-heading">
                <div>
                    <p class="eyebrow dark-eyebrow">YOUR WORKSPACE</p>
                    <h2>My tasks <span class="task-total"><?= count($tasks) ?></span></h2>
                </div>
                <a class="button button-blue" href="create.php">
                    <span class="plus">＋</span> New task
                </a>
            </div>

            <?php if (count($tasks) === 0): ?>
                <div class="empty-state">
                    <div class="empty-icon">✦</div>
                    <h3>A fresh start</h3>
                    <p>Your list is clear. Add a task when you’re ready to plan your next step.</p>
                    <a class="text-link" href="create.php">Create your first task <span>→</span></a>
                </div>
            <?php else: ?>
                <div class="task-list">
                    <?php foreach ($tasks as $task): ?>
                        <?php
                        // A task is overdue only when its due date passed and it is not complete.
                        $isOverdue = !$task['completed']
                            && !empty($task['due_date'])
                            && $task['due_date'] < date('Y-m-d');
                        ?>
                        <article class="task-card <?= $task['completed'] ? 'is-complete' : '' ?> <?= $isOverdue ? 'is-overdue' : '' ?>">
                            <form action="complete.php" method="post" class="complete-form">
                                <input type="hidden" name="id" value="<?= (int) $task['id'] ?>">
                                <input type="hidden" name="completed" value="<?= $task['completed'] ? 0 : 1 ?>">
                                <button
                                    class="task-check <?= $task['completed'] ? 'checked' : '' ?>"
                                    type="submit"
                                    aria-label="<?= $task['completed'] ? 'Mark in progress' : 'Mark completed' ?>"
                                ><?= $task['completed'] ? '✓' : '' ?></button>
                            </form>

                            <div class="task-content">
                                <div class="task-topline">
                                    <span class="category-label"><?= e($task['category'] ?: 'General') ?></span>
                                    <span class="priority-label priority-<?= strtolower(e($task['priority'])) ?>"><?= e($task['priority']) ?> priority</span>
                                    <?php if ($isOverdue): ?>
                                        <span class="overdue-label">Overdue</span>
                                    <?php endif; ?>
                                </div>
                                <h3><?= e($task['title']) ?></h3>
                                <?php if ($task['description'] !== ''): ?>
                                    <p class="task-description"><?= nl2br(e($task['description'])) ?></p>
                                <?php endif; ?>
                                <div class="task-meta">
                                    <span class="calendar-icon">▦</span>
                                    Due <?= e($task['due_date'] ?: 'No due date') ?>
                                    <span class="meta-divider"></span>
                                    <span class="status-label <?= $task['completed'] ? 'status-done' : '' ?>">
                                        <?= $task['completed'] ? 'Completed' : 'In progress' ?>
                                    </span>
                                </div>
                            </div>

                            <div class="task-actions">
                                <a class="edit-link" href="edit.php?id=<?= (int) $task['id'] ?>">Edit</a>
                                <form action="delete.php" method="post" class="delete-form" onsubmit="return confirm('Delete this task?');">
                                    <input type="hidden" name="id" value="<?= (int) $task['id'] ?>">
                                    <button class="delete-button" type="submit" aria-label="Delete <?= e($task['title']) ?>">Delete</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <footer class="footer">
            <span>StudyDesk</span>
            <span>Built for steady progress</span>
        </footer>
    </main>
</div>
</body>
</html>
