<?php

if(isset($_POST['makeTask'])){
    if(isset($_SESSION['user']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['due_date'])){
        if($_POST['title'] != "" && $_POST['description'] != "" && $_POST['due_date'] != ""){
            $query = "INSERT INTO tasks (user_id, title, description, priority, state, due_date, create_date) VALUES ('" . $_SESSION['user']->getId() . "', '" . $_POST['title'] . "', '" . $_POST['description'] . "', '" . $_POST['priority'] . "', '" . 0 . "', '" . $_POST['due_date'] . "', CURDATE());";
            
            $db=DB::connect();
            $db->query($query);
            if($db->insert_id){
                header("Location: index.php");
                exit();
            }
        }
    }
    header("Location: index.php?controller=views&view=makeTask");
    exit();
}

if(isset($_POST['deleteTask'])){
    if(isset($_SESSION['user']) && isset($_POST['task_id'])){
        $query = "DELETE FROM tasks WHERE id = " . $_POST['task_id'] . ";";
        $db=DB::connect();
        $db->query($query);
        header("Location: index.php");
        exit();
    }
}

if(isset($_POST['finishTask'])){
    if(isset($_SESSION['user']) && isset($_POST['task_id'])){
        $query = "UPDATE tasks SET state = 1 WHERE id = " . $_POST['task_id'] . ";";
        $db=DB::connect();
        $db->query($query);
        header("Location: index.php");
        exit();
    }
}

if(isset($_POST['restartTask'])){
    if(isset($_SESSION['user']) && isset($_POST['task_id'])){
        $query = "UPDATE tasks SET state = 0 WHERE id = " . $_POST['task_id'] . ";";
        $db=DB::connect();
        $db->query($query);
        header("Location: index.php");
        exit();
    }
}

if(isset($_POST['editTask'])){
    if(isset($_SESSION['user']) && isset($_POST['task_id']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['due_date'])){
        if($_POST['title'] != "" && $_POST['description'] != "" && $_POST['due_date'] != ""){
            $query = "UPDATE tasks SET title = '" . $_POST['title'] . "', description = '" . $_POST['description'] . "', priority = '" . $_POST['priority'] . "', due_date = '" . $_POST['due_date'] . "' WHERE id = " . $_POST['task_id'] . ";";
            $db=DB::connect();
            $db->query($query);
            header("Location: index.php");
            exit();
        }
    }
    header("Location: index.php?controller=views&view=editTask");
    exit();
}