<?php
session_start();
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="admin-body">

<div class="admin-container">
    <h2>Admin Panel</h2>
    <p class="subtitle">Login to manage notes</p>

    <form action="admin_process.php" method="post">
        <input type="text" name="username" placeholder="Admin Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

   

    <a href="../index.php" class="back-link">Back to Student Login</a>
</div>

</body>
</html>
