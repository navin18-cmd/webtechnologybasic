<?php
session_start();

// Protect page
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Count page visits
$_SESSION['page_visits']++;
$username = $_SESSION['username'];
$login_time = $_SESSION['login_time'];
$visits = $_SESSION['page_visits'];
$has_cookie = isset($_COOKIE['remember']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - TechStore</title>
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
                margin-left:1.5rem;
                transition:color 0.3s; }
        nav a:hover { color:#00d4ff; }
        .container { max-width:900px; margin:2rem auto;
                     padding:0 2rem; }
        .welcome { background:linear-gradient(135deg,
                   #667eea,#764ba2);
                   color:white; padding:2rem;
                   border-radius:12px;
                   margin-bottom:2rem; }
        .welcome h1 { font-size:1.8rem;
                      margin-bottom:0.5rem; }
        .cards { display:grid;
                 grid-template-columns:repeat(
                 auto-fit,minmax(200px,1fr));
                 gap:1.5rem; margin-bottom:2rem; }
        .card { background:white; padding:1.5rem;
                border-radius:12px;
                box-shadow:0 3px 10px rgba(0,0,0,0.1);
                text-align:center; }
        .card-icon { font-size:2.5rem;
                     margin-bottom:0.8rem; }
        .card-title { color:#666; font-size:0.9rem;
                      margin-bottom:0.5rem; }
        .card-value { font-size:1.3rem; font-weight:bold;
                      color:#1a1a2e; }
        .info-box { background:white; padding:1.5rem;
                    border-radius:12px;
                    box-shadow:0 3px 10px rgba(0,0,0,0.1);
                    margin-bottom:1.5rem; }
        .info-box h3 { color:#1a1a2e; margin-bottom:1rem;
                       border-bottom:2px solid #667eea;
                       padding-bottom:0.5rem; }
        .info-row { display:flex; justify-content:space-between;
                    padding:0.7rem 0;
                    border-bottom:1px solid #f0f0f0; }
        .info-label { color:#666; }
        .info-value { font-weight:bold; color:#1a1a2e; }
        .badge { padding:0.3rem 0.8rem; border-radius:20px;
                 font-size:0.85rem; font-weight:bold; }
        .badge-green { background:#e0fff0; color:#2ed573; }
        .badge-blue { background:#e0f0ff; color:#667eea; }
        .btn-logout { background:#ff4757; color:white;
                      padding:0.8rem 2rem; border:none;
                      border-radius:8px; cursor:pointer;
                      font-weight:bold; font-size:1rem;
                      text-decoration:none;
                      display:inline-block; }
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

    <div class="welcome">
        <h1>👋 Welcome, <?= htmlspecialchars($username) ?>!</h1>
        <p>You are logged in to TechStore Dashboard</p>
    </div>

    <div class="cards">
        <div class="card">
            <div class="card-icon">👤</div>
            <div class="card-title">Logged in as</div>
            <div class="card-value">
                <?= htmlspecialchars($username) ?>
            </div>
        </div>
        <div class="card">
            <div class="card-icon">🕐</div>
            <div class="card-title">Login Time</div>
            <div class="card-value"><?= $login_time ?></div>
        </div>
        <div class="card">
            <div class="card-icon">📄</div>
            <div class="card-title">Page Visits</div>
            <div class="card-value"><?= $visits ?></div>
        </div>
        <div class="card">
            <div class="card-icon">🍪</div>
            <div class="card-title">Remember Me</div>
            <div class="card-value">
                <?= $has_cookie ? '✅ Active' : '❌ Off' ?>
            </div>
        </div>
    </div>

    <div class="info-box">
        <h3>📦 Session Information</h3>
        <div class="info-row">
            <span class="info-label">Session ID</span>
            <span class="info-value">
                <?= session_id() ?>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Username</span>
            <span class="info-value">
                <?= htmlspecialchars($username) ?>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Login Time</span>
            <span class="info-value"><?= $login_time ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Session Status</span>
            <span class="info-value">
                <span class="badge badge-green">
                    ✅ Active
                </span>
            </span>
        </div>
    </div>

    <div class="info-box">
        <h3>🍪 Cookie Information</h3>
        <div class="info-row">
            <span class="info-label">Remember Me Cookie</span>
            <span class="info-value">
                <span class="badge 
                    <?= $has_cookie ? 
                    'badge-green' : 'badge-blue' ?>">
                    <?= $has_cookie ? 
                    '✅ Set (7 days)' : '❌ Not Set' ?>
                </span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Cookie Username</span>
            <span class="info-value">
                <?= $has_cookie ? 
                htmlspecialchars($_COOKIE['username']) 
                : 'N/A' ?>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Auto-login</span>
            <span class="info-value">
                <?= $has_cookie ? 
                '✅ Will auto-login next visit' : 
                '❌ Must login manually' ?>
            </span>
        </div>
    </div>

    <a href="logout.php" class="btn-logout">
        🚪 Logout
    </a>

</div>
</body>
</html>