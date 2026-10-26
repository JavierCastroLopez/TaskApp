<?php
if(isset($_GET['view'])){
    require_once("views/".$_GET['view'].".phtml");   
    exit;
}