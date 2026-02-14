<?php
session_start();
include "config/db.php";

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($name) || empty($email) || empty($password)) {
    die("All fields are required!");
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn,
    "INSERT INTO users (name, email, password)
     VALUES (?, ?, ?)"
);

mysqli_stmt_bind_param($stmt, "sss",
    $name,
    $email,
    $hashed_password
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
?>
