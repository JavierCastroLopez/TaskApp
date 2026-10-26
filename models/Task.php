<?php
class Task{
    private $id;
    private $user_id;
    private $title;
    private $description;
    private $priority;
    private $state;
    private $due_date;
    private $create_date;
    private $isShared;

    //maker
    public function __construct($id, $user_id, $title, $description, $priority, $state, $due_date, $create_date) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
        $this->state = $state;
        $this->due_date = $due_date;
        $this->create_date = $create_date;
        $this->isShared = false;
    }
    //getters
    public function getId() {
        return $this->id;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPriority() {
        return $this->priority;
    }

    public function getState() {
        return $this->state;
    }

    public function getDue_date() {
        return $this->due_date;
    }

    public function getCreate_date() {
        return $this->create_date;
    }

    public function setIsShared($isShared) {
        $this->isShared = $isShared;
    }

    public function isShared() {
        return $this->isShared;
    }

    //obtener tareas por id
    public static function getTaskById($id){
        return TaskRepository::getTaskById($id);
    }

    //obtener tareas por id de usuario
    public static function getTaskByUserId($user_id){
        return TaskRepository::getTaskByUserId($user_id);
    }

    //etiquetas de la tarea
    public function getTags() {
        return Tag::getTagsByTaskId($this->id);
    }

    public function hasTag($tag_id) {
        $tags = $this->getTags();
        foreach ($tags as $t) {
            if ($t->getId() == $tag_id) {
                return true;
            }
        }
        return false;
    }

    //filtrar tareas por prioridad, estado y etiqueta
    public static function filterTask($tasks, $priority, $state, $tag = 'all') {
        $filteredTasks = [];
        foreach ($tasks as $task) {
            $matchPriority = ($priority == 'all' || $task->getPriority() == $priority);
            $matchState = ($state == 'all' || $task->getState() == $state);
            $matchTag = ($tag == 'all' || $tag === '' || $task->hasTag($tag));

            if ($matchPriority && $matchState && $matchTag) {
                $filteredTasks[] = $task;
            }
        }
        return $filteredTasks;
    }

    //METODOS DEL COMPARTIR TAREAS
    public static function getUsersWithAccess($task_id){
        return TaskRepository::getUsersWithAccess($task_id);
    }

    public static function getUsersWithOutAccess($task_id, $user_id){
        return TaskRepository::getUsersWithOutAccess($task_id, $user_id);
    }

    //DAR Y QUITAR ACCESO A LAS TAREAS
    public static function shareTask($user_id, $task_id){
        return TaskRepository::shareTask($user_id, $task_id);
    }

    public static function unshareTask($user_id, $task_id){
        return TaskRepository::unshareTask($user_id, $task_id);
    }

    public static function getShareTasks($user_id){
        return TaskRepository::getShareTasks($user_id);
    }
}