<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/User.php';

class TaskRepository {
    // Obtener tareas por id
    public static function getTaskById($id) {
        $query = "SELECT * FROM tasks WHERE id = $id";
        $db = DB::connect();
        $result = $db->query($query);
        if ($task = $result->fetch_assoc()) {
            return new Task($task['id'], $task['user_id'], $task['title'], $task['description'], $task['priority'], $task['state'], $task['due_date'], $task['create_date']);
        }
        return null;
    }

    // Obtener tareas por id de usuario
    public static function getTaskByUserId($user_id) {
        $query = "SELECT * FROM tasks WHERE user_id = " . $user_id;
        $db = DB::connect();
        $result = $db->query($query);
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = new Task($row['id'], $row['user_id'], $row['title'], $row['description'], $row['priority'], $row['state'], $row['due_date'], $row['create_date']);
        }
        return $tasks;
    }

    // Metodos del compartir tareas
    public static function getUsersWithAccess($task_id) {
        $query = "SELECT * FROM shareTasks WHERE task_id = $task_id";
        $db = DB::connect();
        $result = $db->query($query);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = User::getUserById($row['user_id']);
        }
        return $users;
    }

    public static function getUsersWithOutAccess($task_id, $user_id) {
        $query = "SELECT * FROM users WHERE id NOT IN (SELECT user_id FROM shareTasks WHERE task_id = $task_id) AND id != $user_id";
        $db = DB::connect();
        $result = $db->query($query);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = User::getUserById($row['id']);
        }
        return $users; 
    }

    // Dar y quitar acceso a las tareas
    public static function shareTask($user_id, $task_id) {
        $query = "INSERT INTO shareTasks (user_id, task_id) VALUES ('" . $user_id . "', '" . $task_id . "')";
        $db = DB::connect();
        $db->query($query);
    }

    public static function unshareTask($user_id, $task_id) {
        $query = "DELETE FROM shareTasks WHERE user_id = " . $user_id . " AND task_id = " . $task_id;
        $db = DB::connect();
        $db->query($query);
    }

    public static function getShareTasks($user_id) {
        $query = "SELECT * FROM shareTasks WHERE user_id = " . $user_id;
        $db = DB::connect();
        $result = $db->query($query);
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = Task::getTaskById($row['task_id']);
        }
        return $tasks;
    }
}
