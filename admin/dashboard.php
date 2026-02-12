<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "../config/db.php";



/* ===========================
   ADMIN STATISTICS QUERY
   =========================== */

$total_notes = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM notes")
);
$total_notes = $total_notes['total'];

$total_users = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM users")
);
$total_users = $total_users['total'];

$total_downloads = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(downloads) as total FROM notes")
);
$total_downloads = $total_downloads['total'];

$most_downloaded = mysqli_fetch_assoc(
    mysqli_query($conn,
        "SELECT title FROM notes ORDER BY downloads DESC LIMIT 1"
    )
);

$latest_note = mysqli_fetch_assoc(
    mysqli_query($conn,
        "SELECT title FROM notes ORDER BY upload_date DESC LIMIT 1"
    )
);




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

     <!-- ======================
         STATS SECTION START
         ====================== -->

    <div class="stats-section">

    <div class="stat-card">
        <h3>Total Notes</h3>
        <p><?php echo $total_notes; ?></p>
    </div>

    <div class="stat-card">
        <h3>Total Users</h3>
        <p><?php echo $total_users; ?></p>
    </div>

    <div class="stat-card">
        <h3>Total Downloads</h3>
        <p><?php echo $total_downloads ? $total_downloads : 0; ?></p>
    </div>

    <div class="stat-card">
        <h3>Most Popular</h3>
        <p>
        <?php 
        if (isset($most_downloaded['title'])) {
            echo $most_downloaded['title'];
        } else {
            echo "N/A";
        }
        ?>
        </p>
    </div>

    <div class="stat-card">
        <h3>Latest Upload</h3>
        <p>
        <?php 
        if (isset($latest_note['title'])) {
            echo $latest_note['title'];
        } else {
            echo "N/A";
        }
        ?>
        </p>
    </div>

</div>

        

    <!-- Upload Section -->
    <div class="upload-section">
        <h3>Upload New Note</h3>

        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Note Title" required>
            <input type="text" name="subject" placeholder="Subject (e.g. Maths)" required>
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

                $file = $row['file'];
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                echo '<div class="manage-card-full">';

                // Thumbnail for images
                if (in_array($ext, ['png','jpg','jpeg'])) {
                    echo '<img src="../uploads/'.$file.'" class="thumb-img-small">';
                } else {
                    echo '<div class="pdf-icon-small">📄</div>';
                }

                echo '
                    <span>'.$row['title'].'</span>
                    <div>
                        <a href="../uploads/'.$file.'" target="_blank" class="preview-btn">Preview</a>
                        <a href="edit.php?id='.$row['id'].'" class="edit-btn">Edit</a>
                        <a href="delete.php?id='.$row['id'].'" class="delete-btn">Delete</a>
                    </div>
                </div>';
            }

        } else {
            echo "<p class='no-notes'>No notes uploaded yet.</p>";
        }
        ?>
    </div>

</div>

</body>
</html>
