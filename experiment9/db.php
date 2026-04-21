<?php
$host = "sql102.infinityfree.com";        // from InfinityFree
$user = "if0_41717156";    // from InfinityFree
$pass = "gsnavin12345";    // from InfinityFree
$db   = "if0_41717156_techstore";        // from InfinityFree

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>