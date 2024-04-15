<?php
session_start();

var_dump($_POST); // Untuk melihat apa yang dikirimkan dari form

if(!isset($_SESSION['username'])){
    echo "failed"; // Kirim respons "failed" jika pengguna belum login
    exit();
}

// Periksa apakah data tugas sudah dikirimkan melalui form
if(isset($_POST['task_name']) && isset($_POST['task_description'])){
    // Ambil data tugas dari form
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];

    // Simpan data tugas ke dalam database atau tempat penyimpanan lainnya
    // Contoh sederhana: menyimpan data tugas ke dalam array session
    if(!isset($_SESSION['tasks'])){
        $_SESSION['tasks'] = array();
    }
    $_SESSION['tasks'][] = array($task_name, $task_description);

    echo "success"; // Kirim respons "success" jika tugas berhasil ditambahkan
    exit();
} else {
    echo "failed"; // Kirim respons "failed" jika data tugas tidak lengkap
    exit();
}
?>
