<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "../config/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="admin-body">

<div class="admin-dashboard">

    <div class="admin-header">
        <h2>Admin Dashboard</h2>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Upload Section -->
    <div class="upload-section">
        <h3>Upload New Note</h3>

        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Note Title" required>
            <input type="file" name="file" required>
            <button type="submit">Upload Note</button>
        </form>
    </div>

    <!-- Notes Management Section -->
    <div class="manage-section">
        <h3>Manage Notes</h3>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM notes");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="manage-card">
                    <span>'.$row['title'].'</span>
                    <a href="delete.php?id='.$row['id'].'" class="delete-btn">Delete</a>
                </div>
                ';
            }
        } else {
            echo "<p class='no-notes'>No notes uploaded yet.</p>";
        }
        ?>
    </div>

</div>

</body>
</html>
