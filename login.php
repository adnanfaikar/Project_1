<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yuk Login!</title>
    <style>
        .login{
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 100px;
            text-align: center;
            
        }
        input{
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            width: 92%;
        }
        button{
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        a{
            color : black;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login">
            <p><b>LOGIN</b> </p>
            <input type="text" id="username" placeholder="username">
            <input type="password" id="password" placeholder="password">
            <button onclick="login()">Login</button>     
            <a href="register.php">register</a>   
    </div>

    <script>
        function login() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText); // Tambahkan ini untuk mencetak response
                    if(this.responseText.trim() === "success") { // Perbaikan: Gunakan trim() untuk menghapus spasi ekstra
                        window.location.href = "index.php";
                    } else {
                        alert("Login failed. Please check your username and password.");
                    }
                }
            };
            xhr.open("POST", "login_process.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("username=" + username + "&password=" + password);
        }
    </script>

</script>

</body>
</html>
