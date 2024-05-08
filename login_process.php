<?php
session_start();

// Pemeriksaan untuk melihat status $_SESSION sebelum menggunakan $_SESSION['user_id']
// var_dump($_SESSION);

$response = "failed";

require_once "db_config.php";

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Username dan password cocok, set sesi pengguna, ambil user_id, dan berikan respons sukses
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $row['id']; // Perbaikan: Gunakan 'id' sebagai kunci untuk mengambil user_id
        $response = "success";
    } else {
        // Username atau password tidak cocok
        $response = "Username atau password salah";
    }
}

echo $response;
?>
