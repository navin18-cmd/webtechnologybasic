<?php
declare(strict_types=1);

require_once __DIR__ . "/config.php";

$userId = currentUserId();
if ($userId === null) {
    jsonResponse(["success" => false, "message" => "Please login first."], 401);
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    jsonResponse(["success" => false, "message" => "Invalid request."], 405);
}

$goalStmt = $pdo->prepare(
    "SELECT id, total_days
     FROM goals
     WHERE user_id = :user_id AND is_active = 1
     ORDER BY id DESC
     LIMIT 1"
);
$goalStmt->execute(["user_id" => $userId]);
$goal = $goalStmt->fetch();

if (!$goal) {
    jsonResponse(["success" => false, "message" => "Start a goal first."], 400);
}

$goalId = (int) $goal["id"];

$todayCheck = $pdo->prepare("SELECT id FROM progress WHERE goal_id = :goal_id AND done_date = CURDATE() LIMIT 1");
$todayCheck->execute(["goal_id" => $goalId]);
if ($todayCheck->fetch()) {
    jsonResponse(["success" => false, "message" => "Today is already marked done."], 409);
}

$doneDaysStmt = $pdo->prepare("SELECT COUNT(*) AS done_count FROM progress WHERE goal_id = :goal_id");
$doneDaysStmt->execute(["goal_id" => $goalId]);
$doneDays = (int) ($doneDaysStmt->fetch()["done_count"] ?? 0);

if ($doneDays >= (int) $goal["total_days"]) {
    jsonResponse(["success" => false, "message" => "Goal already completed."], 400);
}

$insert = $pdo->prepare("INSERT INTO progress (goal_id, done_date) VALUES (:goal_id, CURDATE())");
$insert->execute(["goal_id" => $goalId]);

$newDoneDays = $doneDays + 1;
if ($newDoneDays >= (int) $goal["total_days"]) {
    $finishGoal = $pdo->prepare("UPDATE goals SET is_active = 0 WHERE id = :goal_id");
    $finishGoal->execute(["goal_id" => $goalId]);
    jsonResponse(["success" => true, "message" => "Great work! Goal completed."], 200);
}

jsonResponse(["success" => true, "message" => "Today marked done."], 200);