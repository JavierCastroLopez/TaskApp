<?php

require_once('models/User.php');
require_once('models/Task.php');
require_once('models/Tag.php');
require_once('repository/UserRepository.php');
require_once('repository/TaskRepository.php');
require_once('repository/TagRepository.php');
require_once('db.php');


session_start();

if(isset($_GET['controller'])){
    require_once("controllers/".$_GET['controller']."Controller.php");   
    exit;
}

require_once("views/mainView.phtml");