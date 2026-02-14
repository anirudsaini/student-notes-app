<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];

/* Get current hashed password */
$stmt = mysqli_prepare($conn,
    "SELECT password FROM users WHERE name = ?"
);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['user']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user || !password_verify($current_password, $user['password'])) {
    die("Current password incorrect!");
}

$new_hashed = password_hash($new_password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn,
    "UPDATE users SET password = ? WHERE name = ?"
);
mysqli_stmt_bind_param($stmt, "ss", $new_hashed, $_SESSION['user']);
mysqli_stmt_execute($stmt);

header("Location: profile.php");
exit();
?>
