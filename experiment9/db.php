<?php
$conn = new mysqli(
    "sql205.infinityfree.com",
    "if0_41650060",
    "gsnavin1234",
    "if0_41650060_techstore"
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>