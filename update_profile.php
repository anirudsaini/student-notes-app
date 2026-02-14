<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$new_name = trim($_POST['name']);

if (empty($new_name)) {
    die("Name cannot be empty!");
}

$stmt = mysqli_prepare($conn,
    "UPDATE users SET name = ? WHERE name = ?"
);

mysqli_stmt_bind_param($stmt, "ss", $new_name, $_SESSION['user']);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

$_SESSION['user'] = $new_name;

header("Location: profile.php");
exit();
?>
