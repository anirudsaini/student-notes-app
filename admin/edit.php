<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM notes WHERE id=$id");
$note = mysqli_fetch_assoc($result);

if (!$note) {
    die("Note not found!");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Note</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="admin-body">

<div class="admin-container">
    <h2>Edit Note</h2>

    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $note['id']; ?>">
        <input type="text" name="title" value="<?php echo $note['title']; ?>" required>
        <button type="submit">Update</button>
    </form>

    <a href="dashboard.php" class="back-link">Back</a>
</div>

</body>
</html>
