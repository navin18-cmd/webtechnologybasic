<?php
declare(strict_types=1);

require_once __DIR__ . "/config.php";

$userId = currentUserId();
if ($userId === null) {
    jsonResponse(["success" => false, "message" => "Please login first."], 401);
}

$historyStmt = $pdo->prepare(
    "SELECT g.goal_name, p.done_date
     FROM progress p
     INNER JOIN goals g ON p.goal_id = g.id
     WHERE g.user_id = :user_id
     ORDER BY p.done_date DESC, p.id DESC
     LIMIT 100"
);
$historyStmt->execute(["user_id" => $userId]);
$history = $historyStmt->fetchAll();

jsonResponse([
    "success" => true,
    "history" => $history,
]);