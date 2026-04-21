<?php
include 'db.php';

$id       = $_POST['id'];
$name     = $_POST['name'];
$price    = $_POST['price'];
$orig     = $_POST['original_price'];
$category = $_POST['category'];
$desc     = $_POST['description'];
$emoji    = $_POST['emoji'];

mysqli_query($conn, "UPDATE products SET
    name='$name', price='$price',
    original_price='$orig', category='$category',
    description='$desc', emoji='$emoji'
    WHERE id=$id");

header("Location: admin.php?success=1");
?>