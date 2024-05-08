<?php
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password'])){
    $conn = new mysqli("localhost", "root", "", "pemweb_project1");

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($password !== $confirm_password){
        header("Location: register.php?error=1");
        exit();
    }
    
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);
    
    if($result->num_rows > 0){
        header("Location: register.php?error=2");
        exit();
    }
    
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if($conn->query($query) === TRUE){
        header("Location: login.php");
        exit();
    } else {
        header("Location: register.php?error=3"); // Redirect to register.php with error code
        exit();
    }
}    
?>
