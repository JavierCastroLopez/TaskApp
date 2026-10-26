<?php
class UserRepository {
    public static function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = $id";
        $db = DB::connect();
        $result = $db->query($query);
        if ($user = $result->fetch_assoc()) {
            return new User($user['id'], $user['name'], $user['username']);
        }
        return null;
    }
}