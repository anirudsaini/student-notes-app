<?php
session_start();

die("Direct admin registration not allowed.");
?>


include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Empty field check
    if (empty($username) || empty($password)) {
        die("All fields are required!");
    }

    // Username length check
    if (strlen($username) < 3) {
        die("Username must be at least 3 characters!");
    }

    // Check if username already exists (Prepared Statement)
    $stmt = mysqli_prepare($conn, "SELECT id FROM admin WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        die("Username already exists!");
    }

    mysqli_stmt_close($stmt);

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new admin (Prepared Statement)
    $stmt = mysqli_prepare($conn, "INSERT INTO admin (username, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Admin Registered Successfully! <br><a href='login.php'>Login Now</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: register.php");
    exit();
}
?>
