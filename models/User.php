<?php
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/Task.php';

class User {
    private $id;
    private $name;
    private $username;

    public function __construct($id, $name, $username) {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getTask() {
        return Task::getTaskByUserId($this->id);
    }

    public static function getUserById($id) {
        return UserRepository::getUserById($id);
    }
}
