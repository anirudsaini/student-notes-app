<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

include "config/db.php";

/* Get user data */
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE name = ?");
mysqli_stmt_bind_param($stmt, "s", $_SESSION['user']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="profile-wrapper">

    <h2>User Profile</h2>

    <div class="profile-card">

        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Joined:</strong> <?php echo $user['created_at']; ?></p>

    </div>

    <h3>Update Name</h3>

    <form action="update_profile.php" method="post">
        <input type="text" name="name" 
            value="<?php echo htmlspecialchars($user['name']); ?>" required>
        <button type="submit">Update Name</button>
    </form>

    <h3>Change Password</h3>

    <form action="change_password.php" method="post">
        <input type="password" name="current_password" placeholder="Current Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <button type="submit">Change Password</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>

</div>

</body>
</html>
