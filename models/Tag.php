<?php
class Tag {
    private $id;
    private $name;

    public function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    //METODOS DE LAS ETIQUETAS
    public static function createTag($name){
        return TagRepository::createTag($name);
    }

    public static function getTagById($id){
        return TagRepository::getTagById($id);
    }

    public static function getTagByName($name){
        return TagRepository::getTagByName($name);
    }

    public static function deleteTag($id){
        return TagRepository::deleteTag($id);
    }

    public static function getAllTags(){
        return TagRepository::getAllTags();
    }

    public static function getTagsByTaskId($task_id){
        return TagRepository::getTagsByTaskId($task_id);
    }

    public static function getAvailableTagsForTask($task_id){
        return TagRepository::getAvailableTagsForTask($task_id);
    }

    public static function addTagToTask($task_id, $tag_id){
        return TagRepository::addTagToTask($task_id, $tag_id);
    }

    public static function removeTagFromTask($task_id, $tag_id){
        return TagRepository::removeTagFromTask($task_id, $tag_id);
    }
}