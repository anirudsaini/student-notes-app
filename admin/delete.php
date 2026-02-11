<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM notes WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if ($row) {
    unlink("../uploads/" . $row['file']);
    mysqli_query($conn, "DELETE FROM notes WHERE id=$id");
}

header("Location: dashboard.php");
?>
