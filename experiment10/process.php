<?php
session_start();

$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Validation
if(empty($username) || empty($password)) {
    header("Location: login.php?error=1");
    exit();
}

if(strlen($password) < 6) {
    header("Location: login.php?error=1");
    exit();
}

// Set Session
$_SESSION['username'] = $username;
$_SESSION['login_time'] = date('Y-m-d H:i:s');
$_SESSION['page_visits'] = 0;

// Set Cookie if Remember Me checked
if(isset($_POST['remember'])) {
    // Cookie lasts 7 days
    setcookie('username', $username, 
              time() + (7 * 24 * 60 * 60), '/');
    setcookie('remember', 'true',
              time() + (7 * 24 * 60 * 60), '/');
}

header("Location: dashboard.php");
exit();
?>