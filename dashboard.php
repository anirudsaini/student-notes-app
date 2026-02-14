<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
include "config/db.php";

/* ===============================
   SEARCH QUERY LOGIC (IMPORTANT)
   =============================== */

if (isset($_GET['search']) && !empty($_GET['search'])) {

    $search = trim($_GET['search']);

    $stmt = mysqli_prepare($conn,
        "SELECT * FROM notes 
         WHERE title LIKE ? OR subject LIKE ?
         ORDER BY upload_date DESC"
    );

    $search_param = "%" . $search . "%";
    mysqli_stmt_bind_param($stmt, "ss", $search_param, $search_param);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

} else {

    $result = mysqli_query($conn,
        "SELECT * FROM notes ORDER BY upload_date DESC"
    );
}
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

    <!-- Search Form -->
    <form method="GET" class="search-form">
        <input type="text" name="search"
            placeholder="Search by title or subject"
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Header -->
    <div class="dashboard-header">
        <h2>Welcome, <?php echo $_SESSION['user']; ?> 👋</h2>
        <a href="logout.php" class="logout-btn">Logout</a>
        <a href="profile.php" class="profile-btn">Profile</a>

    </div>

    <!-- Notes Section -->
    <div class="notes-container">

        <?php
        if ($result && mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                $file = $row['file'];
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                echo '<div class="note-card">';

                /* Thumbnail / PDF Icon */
                if (in_array($ext, ['png','jpg','jpeg'])) {
                    echo '<img src="uploads/'.$file.'" class="thumb-img">';
                } else {
                    echo '<div class="pdf-icon">📄 PDF File</div>';
                }

                echo '
                <h3>'.$row['title'].'</h3>
                <p class="note-meta">
                 Subject: '.$row['subject'].' <br>
                  Size: '.$row['file_size'].' <br>
                 Downloads: '.$row['downloads'].' times <br>
                 Uploaded: '.$row['upload_date'].'
                 </p>
                 <div class="btn-group">
                  <a href="uploads/'.$file.'" target="_blank" class="preview-btn">Preview</a>
                <a href="download.php?file='.$file.'" class="download-btn">Download</a>
                 </div>
                </div>';

            }

        } else {
            echo "<p class='no-notes'>No notes found</p>";
        }
        ?>

    </div>

</div>

</body>
</html>
