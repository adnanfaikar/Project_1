<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
    </style>
</head>
<body>
    <div class="login">
        <p>Register</p>
        <input type="text" id="username" placeholder="username">
        <input type="password" id="password" placeholder="password" id="">
        <input type="password" id="confirm_password" placeholder="confirm password" id="">
        <button onclick="register()">Register</button>        
    </div>

    <script>
        function register() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText == "success") {
                        window.location.href = "login.php";
                    } else {
                        alert("Registration failed. Please try again later.");
                    }
                }
            };
            xhr.open("POST", "register_process.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("username=" + username + "&password=" + password + "&confirm_password=" + confirm_password);
        }
    </script>
</body>
</html>
