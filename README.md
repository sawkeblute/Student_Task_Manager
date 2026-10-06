# Student Task Manager

**Student:** Saw Ke Blute  
**Student ID:** 202300154

StudyDesk is a coursework task manager built with plain PHP, MySQL/MariaDB, HTML, and CSS. It can add, view, edit, complete, and delete tasks. The dashboard shows total, in-progress, and completed task counts, and highlights overdue unfinished tasks.

## Setup

1. Start MySQL or MariaDB.
2. Import `schema.sql` to create the `student_task_manager` database and its `tasks` table.
3. Open `db.php` and change the MySQL username or password if your local setup uses different values.
4. Open this folder in VS Code. In its integrated terminal, run `php -S 127.0.0.1:8000`.
5. Keep that terminal open and visit `http://127.0.0.1:8000` in your browser.
6. Try adding a sample task, editing it, clicking its check circle to change its completion status, and deleting it.

## What each file does

- `index.php`: reads and displays the tasks, calculates the dashboard counts, and highlights overdue unfinished tasks. Its check circle submits the selected task's new status.
- `create.php`: checks new-task input and saves a task with INSERT.
- `edit.php`: loads one task using its ID, checks edited input, and saves changes with UPDATE.
- `task_form.php`: displays the shared styled form used by both `create.php` and `edit.php`.
- `complete.php`: saves the complete or in-progress status submitted by a task's check circle.
- `delete.php`: deletes a task submitted from the list.
- `db.php`: opens the PDO connection to MySQL.
- `functions.php`: contains the `e()` helper, which safely escapes text before showing it in HTML.
- `schema.sql`: creates the database and `tasks` table.
- `style.css`: styles the dashboard, task cards, buttons, and shared add/edit form.

## How the main actions work

**Add:** the shared form sends its fields to `create.php` with POST. PHP checks the title and priority, prepares an INSERT query, and saves the task.

**Show:** `index.php` runs SELECT queries to get the tasks and count completed tasks. A `foreach` loop displays each task.

**Edit:** the Edit link includes the task ID in the URL (GET). `edit.php` uses it to load that task. The shared form sends changes with POST, and PHP saves them with UPDATE.

**Complete:** click a task's check circle. It sends the task ID and new status to `complete.php`, which saves the status with a prepared UPDATE query. Click again to mark it in progress.

**Delete:** the delete form sends the task ID to `delete.php` with POST. PHP runs a prepared DELETE query and returns to the list.

## Assigned challenge

This project highlights overdue tasks: a task is marked overdue when its due date is earlier than today and it is not completed. The dashboard also counts completed tasks. The supplied brief left the instructor-assigned challenge line blank, so confirm that overdue-task highlighting matches the challenge you were assigned.

## AI-use reflection draft

**AI tool used:** ChatGPT.

**Three examples of how AI helped me:**

1. It helped me plan the project files and folder structure.
2. It gave examples of connecting PHP to MySQL with PDO and prepared statements.
3. It explained the add, show, edit, complete, and delete flows.

**One suggestion I changed or rejected:** I kept the project with plain PHP and CSS instead of using a framework or library, because the exam rules do not allow them.

**The part I understand least:** Write the part you personally find hardest after reading and trying the code. For example, if true for you, explain how the values passed to `execute()` match the named placeholders in an SQL query.

This reflection is a draft. Change it so it truthfully describes your own experience and understanding.

## Practice explaining it

Try to explain these in your own words without looking at the answers:

1. What is the difference between GET and POST in this project?
2. Why does PHP use `prepare()` and `execute()` for database queries?
3. What does the `e()` function do?
4. How does the completed-task count get calculated?
5. What does the `foreach` loop do on the task list?
6. How does clicking the check circle change a task's status?
7. How does the program decide whether a task is overdue?
8. What happens if the title is blank?

The assignment includes a no-AI code defense and live modification. Practice making one small change yourself so you can explain it.
