<?php
session_start();

if(!isset($_SESSION['username'])){
    echo "failed";
    exit();
}

if(isset($_POST['index'])){
    $index = $_POST['index'];
    if(isset($_SESSION['tasks'][$index])){
        unset($_SESSION['tasks'][$index]); 
        $_SESSION['tasks'] = array_values($_SESSION['tasks']); 
        echo "success";
        exit();
    }
}

echo "failed";
?>
