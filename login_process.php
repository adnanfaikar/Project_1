<?php
session_start();

$admin_username = "admin";
$admin_password = "admin";

$response = "failed";

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username === $admin_username && $password === $admin_password){
        $_SESSION['username'] = $username;
        $response = "success";
    }
}

echo $response;
?>
