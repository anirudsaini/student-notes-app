<?php
$host = "localhost";
$user = "root";
$pass = "";   // agar MySQL password nahi hai to blank
$db   = "student_notes";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
