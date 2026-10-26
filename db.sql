CREATE DATABASE IF NOT EXISTS taskapp;
USE taskapp;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(50) NOT NULL,
    description TEXT,
    priority ENUM('baja', 'media', 'alta') DEFAULT 'baja',
    state BOOLEAN DEFAULT 0,
    due_date DATE NOT NULL,
    create_date DATE NOT NULL DEFAULT CURRENT_DATE(),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS shareTasks(
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS tags(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS task_tags(
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    tag_id INT NOT NULL,
    UNIQUE KEY (task_id, tag_id),
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

CREATE OR REPLACE VIEW etiquet AS SELECT id, name FROM tags;
CREATE OR REPLACE VIEW task_etiquet AS SELECT id, task_id, tag_id AS etiquet_id FROM task_tags;