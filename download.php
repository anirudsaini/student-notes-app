<?php
include "config/db.php";

if (!isset($_GET['file'])) {
    die("Invalid request!");
}

$file = $_GET['file'];

/* Increase download count */
$stmt = mysqli_prepare($conn,
    "UPDATE notes SET downloads = downloads + 1 WHERE file = ?"
);
mysqli_stmt_bind_param($stmt, "s", $file);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

/* File path */
$file_path = "uploads/" . $file;

if (file_exists($file_path)) {

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
    exit;

} else {
    echo "File not found!";
}
?>
