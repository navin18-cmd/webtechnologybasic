<?php
include 'db.php';

$name     = $_POST['name'];
$price    = $_POST['price'];
$orig     = $_POST['original_price'];
$category = $_POST['category'];
$desc     = $_POST['description'];
$emoji    = $_POST['emoji'];

mysqli_query($conn, "INSERT INTO products 
    (name, price, original_price, category, description, emoji)
    VALUES ('$name','$price','$orig',
            '$category','$desc','$emoji')");

header("Location: admin.php?success=1");
?>