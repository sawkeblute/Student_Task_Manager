CREATE DATABASE IF NOT EXISTS student_task_manager
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE student_task_manager;

CREATE TABLE IF NOT EXISTS tasks (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description TEXT NOT NULL,
  category VARCHAR(50) NOT NULL DEFAULT '',
  priority ENUM('Low', 'Medium', 'High') NOT NULL DEFAULT 'Medium',
  due_date DATE NULL,
  completed TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_tasks_due_date (due_date),
  INDEX idx_tasks_completed (completed)
) ENGINE=InnoDB;
