<?php
session_start();

require_once "db_config.php";

if (!isset($_SESSION['username'])) {
    echo "failed";
    exit();
}

if (isset($_POST['taskId'])) {
    $taskId = $_POST['taskId'];
    
    // Loop through the $_SESSION['tasks'] array to find the task with the given ID
    $taskIndex = null;
    foreach ($_SESSION['tasks'] as $index => $task) {
        if ($task['id'] == $taskId) {
            $taskIndex = $index;
            break;
        }
    }

    // If the task ID is found in the session array
    if ($taskIndex !== null) {
        $task_id = $_SESSION['tasks'][$taskIndex]['id'];

        // echo "Task ID to delete: " . $task_id;

        // Query to delete the task from the database
        $sql = "DELETE FROM tasks WHERE id = $task_id";

        if ($conn->query($sql) === TRUE) {
            // If deletion from the database is successful, remove the task from the session
            unset($_SESSION['tasks'][$taskIndex]);
            $_SESSION['tasks'] = array_values($_SESSION['tasks']);
            echo "success";
        } else {
            echo "Failed to delete task. Error: " . $conn->error;
        }
    } else {
        echo "Invalid task ID.";
    }
} else {
    echo "Failed to delete task. Task ID not provided.";
}

$conn->close();
?>
