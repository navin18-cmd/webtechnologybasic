<?php
session_start();

// Protect page
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$_SESSION['page_visits']++;
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - TechStore</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif;
               background:#f5f5f5; }
        header { background:linear-gradient(135deg,
                 #1a1a2e,#16213e);
                 color:white; padding:1rem 2rem;
                 display:flex; justify-content:space-between;
                 align-items:center; }
        .logo { font-size:1.5rem; font-weight:bold;
                color:#00d4ff; }
        nav a { color:white; text-decoration:none;
                margin-left:1.5rem; }
        nav a:hover { color:#00d4ff; }
        .container { max-width:600px; margin:2rem auto;
                     padding:0 2rem; }
        .profile-card { background:white; padding:2rem;
                        border-radius:12px;
                        box-shadow:0 3px 10px rgba(0,0,0,0.1);
                        text-align:center; }
        .avatar { font-size:5rem; margin-bottom:1rem; }
        .profile-name { font-size:1.8rem; font-weight:bold;
                        color:#1a1a2e; margin-bottom:0.5rem; }
        .profile-badge { background:linear-gradient(135deg,
                         #667eea,#764ba2);
                         color:white; padding:0.4rem 1.2rem;
                         border-radius:20px; font-size:0.9rem;
                         display:inline-block;
                         margin-bottom:2rem; }
        .info-box { background:#f9f9f9; padding:1.5rem;
                    border-radius:8px; text-align:left;
                    margin-bottom:1rem; }
        .info-row { display:flex; justify-content:space-between;
                    padding:0.7rem 0;
                    border-bottom:1px solid #eee; }
        .info-label { color:#666; }
        .info-value { font-weight:bold; color:#1a1a2e; }
        .btn-back { display:inline-block; margin-top:1rem;
                    background:#667eea; color:white;
                    padding:0.8rem 2rem; border-radius:8px;
                    text-decoration:none; font-weight:bold; }
    </style>
</head>
<body>

<header>
    <div class="logo">🛒 TechStore</div>
    <nav>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="profile.php">👤 Profile</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>
</header>

<div class="container">
    <div class="profile-card">
        <div class="avatar">👤</div>
        <div class="profile-name">
            <?= htmlspecialchars($username) ?>
        </div>
        <div class="profile-badge">
            ✅ Active Member
        </div>

        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Username</span>
                <span class="info-value">
                    <?= htmlspecialchars($username) ?>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Login Time</span>
                <span class="info-value">
                    <?= $_SESSION['login_time'] ?>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Pages Visited</span>
                <span class="info-value">
                    <?= $_SESSION['page_visits'] ?>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Session ID</span>
                <span class="info-value">
                    <?= substr(session_id(),0,15) ?>...
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Remember Me</span>
                <span class="info-value">
                    <?= isset($_COOKIE['remember']) ? 
                    '🍪 Cookie Active' : '❌ No Cookie' ?>
                </span>
            </div>
        </div>

        <a href="dashboard.php" class="btn-back">
            ← Back to Dashboard
        </a>
    </div>
</div>
</body>
</html>