<?php
// This form is shared by the Add and Edit pages.
$pageTitle = $pageTitle ?? 'Add a task';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | StudyDesk</title>
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

    <main class="form-page">
        <a class="back-link" href="index.php"><span>←</span> Back to my tasks</a>

        <section class="form-intro">
            <p class="eyebrow dark-eyebrow">PLAN YOUR NEXT STEP</p>
            <h1><?= e($pageTitle) ?></h1>
            <p>Add a few details now. You can always update them later.</p>
        </section>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <strong>Please check these details:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" class="task-form">
            <div class="form-section-title">
                <span class="form-icon">✎</span>
                <div>
                    <h2>Task details</h2>
                    <p>Give your task a clear name and a little context.</p>
                </div>
            </div>

            <label>
                Task title <span class="required">*</span>
                <input name="title" maxlength="150" required
                       placeholder="For example, Review PHP arrays"
                       value="<?= e($values['title']) ?>">
            </label>

            <label>
                Description <span class="optional">Optional</span>
                <textarea name="description" rows="4"
                          placeholder="Add notes or details to help you get started"><?= e($values['description']) ?></textarea>
            </label>

            <div class="form-row">
                <label>
                    Category <span class="optional">Optional</span>
                    <input name="category" maxlength="50"
                           placeholder="For example, Programming"
                           value="<?= e($values['category']) ?>">
                </label>

                <label>
                    Priority
                    <select name="priority" required>
                        <?php foreach (['Low', 'Medium', 'High'] as $priority): ?>
                            <option value="<?= e($priority) ?>"
                                <?= $values['priority'] === $priority ? 'selected' : '' ?>>
                                <?= e($priority) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>

            <label class="date-label">
                Due date <span class="optional">Optional</span>
                <input type="date" name="due_date" value="<?= e($values['due_date']) ?>">
            </label>

            <?php if (isset($values['completed'])): ?>
                <label class="completion-toggle">
                    <input type="checkbox" name="completed" value="1"
                           <?= $values['completed'] ? 'checked' : '' ?>>
                    <span class="toggle-box">✓</span>
                    <span>
                        <strong>Mark as completed</strong>
                        <small>This task is finished.</small>
                    </span>
                </label>
            <?php endif; ?>

            <div class="form-actions">
                <button class="button button-blue" type="submit">
                    <?= $pageTitle === 'Edit task' ? 'Save changes' : 'Create task' ?>
                    <span>→</span>
                </button>
                <a class="cancel-link" href="index.php">Cancel</a>
            </div>
        </form>

        <p class="form-footnote"><span>✦</span> Small steps count. You’ve got this.</p>
    </main>
</div>
</body>
</html>
