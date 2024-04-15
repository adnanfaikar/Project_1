<?php
session_start();

if(!isset($_SESSION['username'])){
    echo "failed"; 
    exit();
}

$upload_directory = "uploads/";

if(isset($_FILES['file_to_upload'])){
    $file_name = $_FILES['file_to_upload']['name'];
    $file_tmp = $_FILES['file_to_upload']['tmp_name'];

    if(move_uploaded_file($file_tmp, $upload_directory.$file_name)){
        echo "success"; 
        exit();
    } else {
        echo "failed"; 
        exit();
    }
} else {
    echo "failed"; 
    exit();
}
?>
