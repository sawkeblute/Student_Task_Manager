# Student Task Manager

**Student Name:** Saw Ke Blute  
**Student ID:** 202300154

This is a coursework task manager built with plain PHP, MySQL, HTML, and CSS. I can add, view, edit, complete, and delete academic tasks. The dashboard shows task totals and highlights unfinished tasks whose due dates have passed.

## Setup

1. Start MySQL.
2. Import `schema.sql`. This creates the `student_task_manager` database and the `tasks` table.
3. Open `db.php`. The default MySQL username is `root` and the password is blank. Change these values if your MySQL setup is different.
4. Open this project folder in VS Code.
5. Open **Terminal → New Terminal** and run `php -S 127.0.0.1:8000`.
6. Keep the terminal open and visit `http://127.0.0.1:8000` in a browser.

## Project Files

- `index.php` reads and displays tasks, calculates the dashboard counts, and highlights overdue unfinished tasks.
- `create.php` checks the new-task form and saves the task with SQL INSERT.
- `edit.php` loads a task using its ID and saves changes with SQL UPDATE.
- `task_form.php` displays the shared form used by the Add and Edit pages.
- `complete.php` saves a task's completed or in-progress status.
- `delete.php` deletes a task from the list.
- `db.php` connects PHP to MySQL using PDO.
- `functions.php` contains `e()`, which escapes text before it is displayed in HTML.
- `schema.sql` creates the database and task table.
- `style.css` styles the dashboard, task cards, buttons, and forms.

## How the Application Works

When I add or edit a task, the browser sends the form values to PHP with POST. PHP checks that the title is not blank and that the priority is valid. It then uses a prepared SQL statement to save the task in MySQL.

The task list uses SELECT to read saved tasks. A `foreach` loop displays each task. The completed count comes from a SQL COUNT query. Clicking a task's check button sends its ID and new status to `complete.php`. The Edit link sends a task ID in the URL with GET. The Delete button sends the task ID with POST.

Before showing user-entered text, the application uses `e()`, which calls `htmlspecialchars()` to display the text safely. Session messages tell me when a task has been added, changed, completed, or deleted.

## Assigned Challenge

The project highlights overdue tasks. An unfinished task is marked **Overdue** when its due date is earlier than today's date. Completed tasks are not marked overdue. The dashboard also counts completed tasks.

## AI-Use Reflection

**AI tool used:** ChatGPT.

**Three examples of how AI helped me:**

1. ChatGPT helped me organize the project into PHP, SQL, CSS, and README files.
2. ChatGPT showed me how PHP connects to MySQL with PDO and prepared statements.
3. ChatGPT helped me understand how the add, view, edit, complete, and delete actions work.

**One AI-generated suggestion or piece of code that I changed or rejected:**

The first version included extra CSRF-token code. I removed that code when I simplified the project because I wanted the PHP flow to be easier for me to understand and explain. I kept the required prepared statements and input checks.

**The part of this application I understand least:**

I find it hardest to follow how the form values match the named placeholders in a PDO query. I need to practice tracing the values from the form, through `execute()`, and into the SQL INSERT or UPDATE statement.
