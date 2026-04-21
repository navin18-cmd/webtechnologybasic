<?php
declare(strict_types=1);

session_start();

$dbHost = "sql201.infinityfree.com";
$dbUser = "YOUR_DB_USER";
$dbPass = "YOUR_DB_PASSWORD";
$dbName = "YOUR_DB_NAME";

try {
    $pdo = new PDO(
        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $exception) {
    http_response_code(500);
    header("Content-Type: application/json");
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

function jsonResponse(array $data, int $code = 200): void
{
    http_response_code($code);
    header("Content-Type: application/json");
    echo json_encode($data);
    exit;
}

function getJsonInput(): array
{
    $raw = file_get_contents("php://input");
    if (!$raw) {
        return [];
    }

    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

function currentUserId(): ?int
{
    if (!isset($_SESSION["user_id"])) {
        return null;
    }

    return (int) $_SESSION["user_id"];
}