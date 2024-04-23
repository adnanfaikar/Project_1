<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid white;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        body{
            background-color: #05143A;
            color : #FFA500;
        }
        h1{
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Project Management</h1>

    <h2>Add New Task</h2>
    <form action="" id="addTaskForm">
        <label for="task_name">Task Name:</label><br>
        <input type="text" id="task_name" name="task_name"><br>
        <label for="task_description">Task Description:</label><br>
        <textarea id="task_description" name="task_description"></textarea><br>
        <button type="submit">Add Task</button>
    </form>

    <hr>

    <h2>Task List</h2>
    <table border="1">
        <tr>
            <th>Task Name</th>
            <th>Description</th>
            <th>Action</th> 
        </tr>
        <?php

        if(isset($_SESSION['tasks'])){
            foreach($_SESSION['tasks'] as $index => $task){ 
                echo "<tr>";
                echo "<td>".$task[0]."</td>";
                echo "<td>".$task[1]."</td>";
                echo "<td><button class='deleteTask' data-index='".$index."'>Delete</button></td>"; 
                echo "</tr>";
            }
        }

        ?>
    </table>

    <hr>

    <h2>Upload File</h2>
    <form id="uploadForm" enctype="multipart/form-data"> 
        <input type="file" id="file_to_upload" name="file_to_upload"><br>
        <button type="submit">Upload File</button>
    </form>

    <script>
        $(document).ready(function(){
            $('#addTaskForm').submit(function(e){
                e.preventDefault(); 
                $.ajax({
                    type: 'POST',
                    url: 'add_task.php',
                    data: $(this).serialize(),
                    success: function(response){
                        console.log(response);
                        if(response.trim() == 'success'){
        
                            alert('Task added successfully!');
                            location.reload();
                        } else {
                            alert('Failed to add task.');
                        }
                    }
                });
            });

            $(document).on('click', '.deleteTask', function(){
                var index = $(this).data('index');
                var confirmed = confirm("Are you sure you want to delete this task?"); 
                if(confirmed){
                    $.ajax({
                        type: 'POST',
                        url: 'delete_task.php',
                        data: { index: index },
                        success: function(response){
                            if(response == 'success'){
                                alert('Task deleted successfully!');
                                location.reload();
                            } else {
                                alert('Failed to delete task.');
                            }
                        }
                    });
                }
            });
        });

        $(document).ready(function(){
            $('#uploadForm').submit(function(e){
                e.preventDefault(); 
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: 'upload_file.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        if(response == 'success'){
                            alert('File uploaded successfully!');
                            location.reload();
                        } else {
                            alert('Failed to upload file.');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
