<?php
include "../config/db.php";

$title = $_POST['title'];
$file = $_FILES['file']['name'];
$tmp = $_FILES['file']['tmp_name'];

move_uploaded_file($tmp, "../uploads/".$file);

mysqli_query($conn,
"INSERT INTO notes(title,file) VALUES('$title','$file')");

echo "Uploaded Successfully";
?>
