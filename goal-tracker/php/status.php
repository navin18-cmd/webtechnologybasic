<?php
declare(strict_types=1);

require_once __DIR__ . "/config.php";

$userId = currentUserId();
if ($userId === null) {
    jsonResponse([
        "loggedIn" => false,
        "user_name" => null,
    ]);
}

jsonResponse([
    "loggedIn" => true,
    "user_name" => $_SESSION["user_name"] ?? "User",
]);