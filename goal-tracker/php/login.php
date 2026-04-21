<?php
declare(strict_types=1);

require_once __DIR__ . "/config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    jsonResponse(["success" => false, "message" => "Invalid request."], 405);
}

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$remember = isset($_POST["remember"]);

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
    jsonResponse(["success" => false, "message" => "Invalid input."], 400);
}

$stmt = $pdo->prepare("SELECT id, name, password_hash FROM users WHERE email = :email LIMIT 1");
$stmt->execute(["email" => $email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user["password_hash"])) {
    jsonResponse(["success" => false, "message" => "Invalid email or password."], 401);
}

$_SESSION["user_id"] = (int) $user["id"];
$_SESSION["user_name"] = $user["name"];

if ($remember) {
    setcookie("remember_email", $email, time() + (86400 * 30), "/");
}

header("Location: ../index.html");
exit;