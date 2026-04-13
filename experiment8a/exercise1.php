<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $age = trim($_POST['age']);

    if (empty($name) || empty($email) || empty($age)) {
        echo "All fields are required.";
    }
    elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        echo "Only letters and spaces allowed in name.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    }
    elseif ($age < 18 || $age > 60) {
        echo "Age must be between 18 and 60.";
    }
    else {
        echo "<h2>Form Submitted Successfully!</h2>";
        echo "Name: " . htmlspecialchars($name) . "<br>";
        echo "Email: " . htmlspecialchars($email) . "<br>";
        echo "Age: " . htmlspecialchars($age);
    }
}
?>