<?php
session_start();

require_once "db_config.php";

if(isset($_GET['logout'])){
    unset($_SESSION['username']);
    header("Location: login.php");
    exit();
}

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM tasks WHERE user_id = $user_id";
$result = $conn->query($sql);

$tasks = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
    // Simpan tugas ke dalam sesi
    $_SESSION['tasks'] = $tasks;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Stylesheet untuk font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Menggunakan font Poppins untuk seluruh teks di halaman */
        body {
            font-family: 'Poppins', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        body{
            background-color: #aec6cf;
            color : black;
        }
        h1,h2{
            text-align: center;
        }
        h1{
            font-size: 40px;
            margin: 0px;
        }
        hr{
            border: 1px solid black;
        }
        button{
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        textarea{
            border-radius: 5px;
        }
        input{
            border-radius: 5px;
        }
        .header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PROJECT MANAGEMENT</h1>
        <button><a href="?logout=true" style="text-decoration: none; color: white;">Logout</a></button>


    </div>
    <hr>

    <h3>Add New Task</h3>
    <form action="" id="addTaskForm">
        <label for="task_name">Task Name:</label><br>
        <input type="text" id="task_name" name="task_name"><br>
        <label for="task_description">Task Description:</label><br>
        <textarea id="task_description" name="task_description"></textarea><br>
        <button type="submit">Add Task</button>
    </form>

    <!-- <hr> -->

    <h2>Task List</h2>
    <table border="1">
        <tr>
            <th>Task Name</th>
            <th>Description</th>
            <th>Action</th> 
        </tr>
        <?php
        foreach($tasks as $task){ 
            echo "<tr>";
            echo "<td>".$task['task_name']."</td>";
            echo "<td>".$task['task_description']."</td>";
            echo "<td><button class='deleteTask' data-taskid='".$task['id']."'>Delete</button></td>";
            echo "</tr>";
        }
        ?>
    </table>


    <h3>Upload File</h3>
    <p>This Uploading Section is for adding file attachment such as assignment attachment, etc</p>
    <form id="uploadForm" enctype="multipart/form-data"> 
        <input type="file" id="file_to_upload" name="file_to_upload"><br>
        <button type="submit">Upload File</button>
        <!-- Preview Image -->
        <div id="previewContainer" style="display: none;">
            <h4>Preview:</h4>
            <img id="previewImage" class="preview-image" src="#" alt="Preview" style="max-width: 200px; max-height: 400px;">
        </div>
    </form>
    <h3>Uploaded File</h3>
        <div id="uploadedFilesContainer">
            <!-- Uploaded files will be loaded here -->
        </div>
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
    var taskId = $(this).data('taskid');
    console.log("Clicked task ID:", taskId); // Periksa apakah taskId tercetak di sini dengan benar
    var confirmed = confirm("Are you sure you want to delete this task?"); 
    if(confirmed){
        console.log("Deleting task with ID:", taskId); // Periksa lagi taskId di sini
        $.ajax({
            type: 'POST',
            url: 'delete_task.php',
            data: { taskId: taskId }, // Pastikan bahwa data taskId dikirimkan ke backend
            success: function(response){
                console.log("Delete task response:", response); // Periksa respons dari server
                if(response == 'success'){
                    alert('Task deleted successfully!');
                    location.reload();
                } else {
                    console.log("Failed to delete task. Error:", response);
                    alert('Failed to delete task.');
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX request failed. Status:", status, ", Error:", error);
                alert('Failed to delete task.');
            }
        });
    }
});

    $(document).on('change', '#file_to_upload', function(e){
        var file = e.target.files[0];
        var fileType = file.type;
        var validImageTypes = ["image/jpeg", "image/png"];
        
        if (validImageTypes.includes(fileType)) {
            // Valid image file type
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
                $('#previewContainer').show();
            }
            reader.readAsDataURL(file);
        } else {
            // Invalid file type
            alert("File must be in JPG or PNG format.");
            $('#previewContainer').hide();
            $('#file_to_upload').val(''); // Clear the file input
        }
    });

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
                    loadUploadedFiles();
                    location.reload();
                } else {
                    alert('Failed to upload file.');
                }
            }
        });
    });

    function loadUploadedFiles() {
    $.ajax({
        type: 'GET',
        url: 'load_files.php',
        success: function(response){
            $('#uploadedFilesContainer').html(response);
        }
    });
    }

    $(document).ready(function() {
        loadUploadedFiles();
    });

    });

    $(document).ready(function() {
    $('#deleteForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'delete_files.php',
            data: formData,
            success: function(response) {
                if (response == 'success') {
                    alert('Files deleted successfully!');
                    location.reload();
                } else {
                    alert('Failed to delete files.');
                }
            }
        });
    });
});


    </script>
</body>
</html>
