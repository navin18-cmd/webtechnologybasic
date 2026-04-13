<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Username and Password are required.";
    }
    elseif (strlen($password) < 6) {
        echo "Password must be at least 6 characters.";
    }
    else {
        echo "<h2>Login Successful!</h2>";
        echo "Welcome, " . htmlspecialchars($username);
    }
}
?>