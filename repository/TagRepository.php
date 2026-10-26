<?php
class TagRepository {
    //METODOS DE LAS ETIQUETAS
    public static function createTag($name) {
        $db = DB::connect();
        $name = strtolower($name);
        if ($name == '') {
            return null;
        }

        //comprobar si ya existe para evitar duplicados
        $checkQuery = "SELECT * FROM tags WHERE name = '" . $name . "'";
        $result = $db->query($checkQuery);
        if ($row = $result->fetch_assoc()) {
            return new Tag($row['id'], $row['name']);
        }

        $query = "INSERT INTO tags (name) VALUES ('" . $name . "')";
        if ($db->query($query)) {
            return new Tag($db->insert_id, $name);
        }
        return null;
    }

    public static function getTagById($id) {
        $db = DB::connect();
        $query = "SELECT * FROM tags WHERE id = " . $id;
        $result = $db->query($query);
        if ($row = $result->fetch_assoc()) {
            return new Tag($row['id'], $row['name']);
        }
        return null;
    }

    public static function getTagByName($name) {
        $db = DB::connect();
        $name = strtolower($name);
        $query = "SELECT * FROM tags WHERE name = '" . $name . "'";
        $result = $db->query($query);
        if ($row = $result->fetch_assoc()) {
            return new Tag($row['id'], $row['name']);
        }
        return null;
    }

    public static function deleteTag($id) {
        $db = DB::connect();
        $query = "DELETE FROM tags WHERE id = " . $id;
        $db->query($query);
    }

    public static function getAllTags() {
        $db = DB::connect();
        $query = "SELECT * FROM tags";
        $result = $db->query($query);
        $tags = [];
        while ($row = $result->fetch_assoc()) {
            $tags[] = new Tag($row['id'], $row['name']);
        }
        return $tags;
    }

    //METODOS DE ASOCIACION CON TAREAS
    public static function getTagsByTaskId($taskId) {
        $db = DB::connect();
        $query = "SELECT t.* FROM tags t INNER JOIN task_tags tt ON t.id = tt.tag_id WHERE tt.task_id = " . $taskId;
        $result = $db->query($query);
        $tags = [];
        while ($row = $result->fetch_assoc()) {
            $tags[] = new Tag($row['id'], $row['name']);
        }
        return $tags;
    }

    public static function getAvailableTagsForTask($taskId) {
        $db = DB::connect();
        $query = "SELECT * FROM tags WHERE id NOT IN (SELECT tag_id FROM task_tags WHERE task_id = " . $taskId . ")";
        $result = $db->query($query);
        $tags = [];
        while ($row = $result->fetch_assoc()) {
            $tags[] = new Tag($row['id'], $row['name']);
        }
        return $tags;
    }

    public static function addTagToTask($taskId, $tagId) {
        $db = DB::connect();
        $query = "INSERT INTO task_tags (task_id, tag_id) VALUES ('" . $taskId . "', '" . $tagId . "')";
        $db->query($query);
    }

    public static function removeTagFromTask($taskId, $tagId) {
        $db = DB::connect();
        $query = "DELETE FROM task_tags WHERE task_id = " . $taskId . " AND tag_id = " . $tagId;
        $db->query($query);
    }
}
