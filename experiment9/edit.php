<?php
include 'db.php';
$id = $_GET['id'];
$result = mysqli_query($conn, 
    "SELECT * FROM products WHERE id=$id");
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif;
               background:#f5f5f5; }
        .header { background:linear-gradient(135deg,
                  #1a1a2e,#16213e);
                  color:white; padding:1rem 2rem; }
        .container { max-width:600px; margin:2rem auto;
                     padding:0 2rem; }
        .form-card { background:white; padding:2rem;
                     border-radius:8px;
                     box-shadow:0 3px 10px rgba(0,0,0,0.1); }
        h2 { color:#1a1a2e; margin-bottom:1.5rem; }
        .form-group { margin-bottom:1rem;
                      display:flex; flex-direction:column;
                      gap:0.5rem; }
        label { font-weight:bold; }
        input, select, textarea {
            padding:0.8rem; border:1px solid #ddd;
            border-radius:5px; font-size:1rem; }
        textarea { height:80px; resize:vertical; }
        .btn { width:100%; padding:0.8rem; border:none;
               border-radius:5px; background:#667eea;
               color:white; font-weight:bold;
               font-size:1rem; cursor:pointer;
               margin-top:1rem; }
        .btn:hover { background:#764ba2; }
        .back { display:inline-block; margin-top:1rem;
                color:#667eea; text-decoration:none; }
    </style>
</head>
<body>
<div class="header">
    <h1>🛒 Edit Product</h1>
</div>
<div class="container">
    <div class="form-card">
        <h2>✏️ Edit Product</h2>
        <form method="POST" action="update.php">
            <input type="hidden" name="id" 
                   value="<?= $row['id'] ?>">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" 
                       value="<?= $row['name'] ?>" required>
            </div>
            <div class="form-group">
                <label>Emoji</label>
                <input type="text" name="emoji" 
                       value="<?= $row['emoji'] ?>" required>
            </div>
            <div class="form-group">
                <label>Price (₹)</label>
                <input type="number" name="price" 
                       value="<?= $row['price'] ?>" required>
            </div>
            <div class="form-group">
                <label>Original Price (₹)</label>
                <input type="number" name="original_price"
                       value="<?= $row['original_price'] ?>" 
                       required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category" required>
                    <option value="electronics" 
                        <?= $row['category']=='electronics' 
                        ? 'selected' : '' ?>>
                        Electronics
                    </option>
                    <option value="accessories"
                        <?= $row['category']=='accessories' 
                        ? 'selected' : '' ?>>
                        Accessories
                    </option>
                    <option value="gadgets"
                        <?= $row['category']=='gadgets' 
                        ? 'selected' : '' ?>>
                        Gadgets
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description">
                    <?= $row['description'] ?>
                </textarea>
            </div>
            <button type="submit" class="btn">
                💾 Update Product
            </button>
        </form>
        <a href="admin.php" class="back">← Back to Admin</a>
    </div>
</div>
</body>
</html>