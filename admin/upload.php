<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "../config/db.php";

/* Title + Subject */
$title   = trim($_POST['title']);
$subject = trim($_POST['subject']);

if (empty($title) || empty($subject)) {
    die("Title and Subject are required!");
}

/* File validation */
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
    die("File upload error!");
}

$file_name = $_FILES['file']['name'];
$file_tmp  = $_FILES['file']['tmp_name'];
$file_size_bytes = $_FILES['file']['size'];
$file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

/* Allowed extensions */
$allowed = array("pdf", "png", "jpg", "jpeg");

if (!in_array($file_ext, $allowed)) {
    die("Only PDF, PNG, JPG, JPEG files are allowed!");
}

/* File size limit (5MB) */
if ($file_size_bytes > 5 * 1024 * 1024) {
    die("File size must be less than 5MB!");
}

/* Convert size to KB */
$file_size = round($file_size_bytes / 1024, 2) . " KB";

/* Unique file name */
$new_name = time() . "_" . uniqid() . "." . $file_ext;

/* Move file */
if (move_uploaded_file($file_tmp, "../uploads/" . $new_name)) {

    /* Insert into database */
    $stmt = mysqli_prepare($conn,
        "INSERT INTO notes (title, subject, file, file_size) 
         VALUES (?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param($stmt, "ssss", 
        $title, 
        $subject, 
        $new_name, 
        $file_size
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: dashboard.php");
    exit();

} else {
    echo "Failed to upload file!";
}
?>
