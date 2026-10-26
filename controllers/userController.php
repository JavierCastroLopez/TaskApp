<?php

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
    exit;
}

if(isset($_POST['login'])){
    if(isset($_POST['username']) && isset($_POST['password'])){
        if($_POST['username']!="" && $_POST['password']!=""){            
            $query="select * from users where username= '".$_POST['username']."'";

            $db=DB::connect();
            $result = $db->query($query);
            if($row = $result->fetch_assoc()){
                if(md5($_POST['password'])==$row['password']){
                    $_SESSION['user']=new User($row['id'], $row['name'], $row['username']);
                }
            }
        }
        header("Location: index.php");
        exit;
    }
}

if(isset($_POST['register'])){
    if(isset($_POST['username']) && isset($_POST['name']) && isset($_POST['password']) && isset($_POST['password2'])){
        if($_POST['username']!="" && $_POST['name']!="" && $_POST['password']!="" && $_POST['password2']!=""){
            if($_POST['password']==$_POST['password2']){
            $db=DB::connect();
            //revisar que el username no este registrado
            $q="select * from users where username= '".$_POST['username']."'";
            $result = $db->query($q);
            if($result->num_rows>0){
                //crear una variable info si existe el usuario
                $_SESSION['info']="El usuario ya existe";
                header("Location: index.php?controller=views&view=register");
                exit();
            }else{            
            $q="insert into users (username,name,password) values ('" . $_POST['username'] . "','" . $_POST['name'] . "',md5('" .$_POST['password']. "'));";
            $db->query($q);
            if($db->insert_id){
                header("Location: index.php?controller=views&view=login");
                exit();
            }
        }
    }
    }
    header("Location: index.php?controller=views&view=register");
    exit();
}
}
