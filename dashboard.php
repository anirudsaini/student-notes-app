<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
include "config/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="dashboard-wrapper">

    <div class="dashboard-header">
        <h2>Welcome, <?php echo $_SESSION['user']; ?> 👋</h2>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="notes-container">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM notes");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="note-card">
                    <h3>'.$row['title'].'</h3>
                    <a href="uploads/'.$row['file'].'" download class="download-btn">
                        Download
                    </a>
                </div>
                ';
            }
        } else {
            echo "<p class='no-notes'>No notes available</p>";
        }
        ?>
    </div>

</div>

</body>
</html>
