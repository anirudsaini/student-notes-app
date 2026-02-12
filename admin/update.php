<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

$id = $_POST['id'];
$title = trim($_POST['title']);

if (empty($title)) {
    die("Title cannot be empty!");
}

mysqli_query($conn,
    "UPDATE notes SET title='$title' WHERE id=$id");

header("Location: dashboard.php");
exit();
?>
