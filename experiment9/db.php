<?php
$conn = mysqli_connect(
    "sql205.infinityfree.com",
    "if0_41650060",
    "gsnavin1234",
    "if0_41650060_techstore"
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>