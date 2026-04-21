<?php
declare(strict_types=1);

session_start();

$dbHost = "sqlXXX.infinityfree.com";
$dbPort = "3306";
$dbUser = "if0_xxxxxxxx";
$dbPass = "YOUR_DB_PASSWORD";
$dbName = "if0_xxxxxxxx_goaltracker";

try {
    $pdo = new PDO(
        "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $exception) {
    error_log("Goal Tracker DB error: " . $exception->getMessage());
    http_response_code(500);
    header("Content-Type: application/json");
    echo json_encode(["success" => false, "message" => "Database connection failed. Check DB host, username, password, and database name."]);
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
