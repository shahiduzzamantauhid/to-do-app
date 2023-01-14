<?php
include_once('confiq.php');

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(!$connection){
    throw new Exception ('Could not connect to database');
}else{
    $action = $_POST['action'] ?? '';
    if(!$action){
        header('Location: index.php');
    }else{
        if('add' == $action){
            $task = $_POST['task'] ?? '';
            $date = $_POST['ddate'] ?? '';
            $query = "INSERT INTO tasks(task, date) VALUES('$task', '$date')";
            mysqli_query($connection, $query);
            header('Location: index.php?added=true');
            //mysqli_query($connection, "TRUNCATE TABLE tasks");
        }
        else if('complete'==$action){
            $id = $_POST['taskdata'];
            if($id){
                $query = "UPDATE tasks SET complete=1 WHERE id={$id}";
                mysqli_query($connection, $query);
                header('Location: index.php');
            }
            //$query = SELECT FROM tasks WHERE complete = 0 LIMIT 1;
        }
        else if('delete'==$action){
            $del_id = $_POST['deldata'];
            if($del_id){
                $dquery = "DELETE FROM tasks WHERE id = {$del_id}";
                mysqli_query($connection, $dquery);
                header('Location: index.php');
            }//$query = SELECT FROM tasks WHERE complete = 0 LIMIT 1;
        }
    } 
}
mysqli_close($connection);