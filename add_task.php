<?php
session_start();

require_once "db_config.php";

if(!isset($_SESSION['username'])){
    echo "failed"; 
    exit();
}

// Ambil data dari form
if(isset($_POST['task_name']) && isset($_POST['task_description'])){
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $user_id = $_SESSION['user_id']; // Anda perlu mengambil user_id dari sesi

    // Siapkan statement SQL untuk menyimpan task baru
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name, task_description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $task_name, $task_description);

    // Eksekusi statement
    if ($stmt->execute()) {
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