<?php
session_start();

// Auto-login if cookie exists
if(isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
    header("Location: dashboard.php");
    exit();
}

// Already logged in
if(isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TechStore - Login</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif;
               background:linear-gradient(135deg,
               #667eea,#764ba2);
               min-height:100vh;
               display:flex; align-items:center;
               justify-content:center; }
        .login-card { background:white; padding:2.5rem;
                      border-radius:12px; width:100%;
                      max-width:400px;
                      box-shadow:0 10px 30px rgba(0,0,0,0.2); }
        .logo { text-align:center; font-size:2rem;
                font-weight:bold; color:#667eea;
                margin-bottom:0.5rem; }
        h2 { text-align:center; color:#1a1a2e;
             margin-bottom:2rem; }
        .form-group { margin-bottom:1.2rem; }
        label { display:block; font-weight:bold;
                color:#333; margin-bottom:0.5rem; }
        input[type="text"],
        input[type="password"] {
            width:100%; padding:0.8rem;
            border:2px solid #ddd; border-radius:8px;
            font-size:1rem; transition:border 0.3s; }
        input:focus { border-color:#667eea; outline:none; }
        .remember { display:flex; align-items:center;
                    gap:0.5rem; margin-bottom:1.5rem; }
        .remember input { width:auto; }
        .remember label { font-weight:normal;
                          margin:0; color:#666; }
        .btn { width:100%; padding:0.9rem;
               background:linear-gradient(135deg,
               #667eea,#764ba2);
               color:white; border:none; border-radius:8px;
               font-size:1rem; font-weight:bold;
               cursor:pointer; transition:opacity 0.3s; }
        .btn:hover { opacity:0.9; }
        .error { background:#ffe0e0; color:#ff4757;
                 padding:0.8rem; border-radius:8px;
                 margin-bottom:1rem; text-align:center; }
        .info { background:#e0f0ff; color:#667eea;
                padding:0.8rem; border-radius:8px;
                margin-bottom:1rem; text-align:center;
                font-size:0.9rem; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="logo">🛒 TechStore</div>
    <h2>Welcome Back!</h2>

    <?php if(isset($_GET['error'])): ?>
        <div class="error">
            ❌ Invalid username or password!
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['logout'])): ?>
        <div class="info">
            ✅ You have been logged out!
        </div>
    <?php endif; ?>

    <div class="info">
        💡 Use any username & password (min 6 chars)
    </div>

    <form method="POST" action="process.php">
        <div class="form-group">
            <label>👤 Username</label>
            <input type="text" name="username"
                   placeholder="Enter username" required>
        </div>
        <div class="form-group">
            <label>🔒 Password</label>
            <input type="password" name="password"
                   placeholder="Enter password" required>
        </div>
        <div class="remember">
            <input type="checkbox" name="remember"
                   id="remember">
            <label for="remember">
                🍪 Remember me for 7 days
            </label>
        </div>
        <button type="submit" class="btn">
            Login →
        </button>
    </form>
</div>
</body>
</html>