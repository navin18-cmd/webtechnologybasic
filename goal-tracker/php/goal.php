<?php
declare(strict_types=1);

require_once __DIR__ . "/config.php";

$userId = currentUserId();
if ($userId === null) {
    jsonResponse(["success" => false, "message" => "Please login first."], 401);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = getJsonInput();
    $goalName = trim((string) ($input["goal_name"] ?? ""));
    $totalDays = (int) ($input["total_days"] ?? 0);

    if ($goalName === "" || $totalDays < 1 || $totalDays > 365) {
        jsonResponse(["success" => false, "message" => "Invalid goal data."], 400);
    }

    $deactivate = $pdo->prepare("UPDATE goals SET is_active = 0 WHERE user_id = :user_id AND is_active = 1");
    $deactivate->execute(["user_id" => $userId]);

    $insert = $pdo->prepare(
        "INSERT INTO goals (user_id, goal_name, total_days, start_date, is_active) VALUES (:user_id, :goal_name, :total_days, CURDATE(), 1)"
    );
    $insert->execute([
        "user_id" => $userId,
        "goal_name" => $goalName,
        "total_days" => $totalDays,
    ]);

    jsonResponse(["success" => true, "message" => "Goal started."]); 
}

$goalStmt = $pdo->prepare(
    "SELECT id, goal_name, total_days, start_date
     FROM goals
     WHERE user_id = :user_id AND is_active = 1
     ORDER BY id DESC
     LIMIT 1"
);
$goalStmt->execute(["user_id" => $userId]);
$goal = $goalStmt->fetch();

if (!$goal) {
    jsonResponse(["success" => true, "goal" => null]);
}

$goalId = (int) $goal["id"];

$doneDaysStmt = $pdo->prepare("SELECT COUNT(*) AS done_count FROM progress WHERE goal_id = :goal_id");
$doneDaysStmt->execute(["goal_id" => $goalId]);
$doneDays = (int) ($doneDaysStmt->fetch()["done_count"] ?? 0);

$datesStmt = $pdo->prepare("SELECT done_date FROM progress WHERE goal_id = :goal_id ORDER BY done_date DESC");
$datesStmt->execute(["goal_id" => $goalId]);
$dates = $datesStmt->fetchAll(PDO::FETCH_COLUMN);

$streak = 0;
$missedDay = false;
$expected = new DateTimeImmutable("today");

foreach ($dates as $doneDate) {
    $entryDate = new DateTimeImmutable((string) $doneDate);
    if ($entryDate->format("Y-m-d") === $expected->format("Y-m-d")) {
        $streak++;
        $expected = $expected->modify("-1 day");
    } elseif ($entryDate < $expected) {
        break;
    }
}

if (!empty($dates)) {
    $latest = new DateTimeImmutable((string) $dates[0]);
    $diff = (int) $latest->diff(new DateTimeImmutable("today"))->format("%a");
    $missedDay = $diff > 1;
}

jsonResponse([
    "success" => true,
    "goal" => [
        "goal_id" => $goalId,
        "goal_name" => $goal["goal_name"],
        "total_days" => (int) $goal["total_days"],
        "done_days" => $doneDays,
        "streak" => $streak,
        "missed_day" => $missedDay,
    ],
]);