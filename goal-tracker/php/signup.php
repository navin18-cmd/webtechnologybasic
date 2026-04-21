<?php
declare(strict_types=1);

require_once __DIR__ . "/config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    jsonResponse(["success" => false, "message" => "Invalid request."], 405);
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
    jsonResponse(["success" => false, "message" => "Invalid input."], 400);
}

$check = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
$check->execute(["email" => $email]);
if ($check->fetch()) {
    jsonResponse(["success" => false, "message" => "Email already registered."], 409);
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$insert = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :password_hash)");
$insert->execute([
    "name" => $name,
    "email" => $email,
    "password_hash" => $passwordHash,
]);

$_SESSION["user_id"] = (int) $pdo->lastInsertId();
$_SESSION["user_name"] = $name;

header("Location: ../index.html");
exit;