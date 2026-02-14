<?php
session_start();
die("Admin self registration is disabled.");
?>

include "../config/db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="admin-body">

<div class="admin-container">
    <h2>Admin Registration</h2>
    <p class="subtitle">Create new admin account</p>

    <form action="register_process.php" method="post">
        <input type="text" name="username" placeholder="Admin Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>

    <a href="login.php" class="back-link">Back to Login</a>
</div>

</body>
</html>
