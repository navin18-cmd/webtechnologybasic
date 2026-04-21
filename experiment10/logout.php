<?php
session_start();

// Destroy session
session_unset();
session_destroy();

// Clear cookies
setcookie('username', '', time() - 3600, '/');
setcookie('remember', '', time() - 3600, '/');

header("Location: login.php?logout=1");
exit();
?>