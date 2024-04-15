<?php
if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])){
    $conn = new mysqli("localhost", "username", "password", "nama_database");

    $username = $_POST['username'];
    $email = $_POST['email'];
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

    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if($conn->query($query) === TRUE){
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
} else {
    header("Location: register.php");
}
?>
