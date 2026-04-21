<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - TechStore</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Segoe UI', sans-serif; 
               background:#f5f5f5; }
        .header { background: linear-gradient(135deg, 
                  #1a1a2e, #16213e);
                  color:white; padding:1rem 2rem;
                  display:flex; justify-content:space-between;
                  align-items:center; }
        .header a { color:#00d4ff; text-decoration:none; }
        .container { max-width:1000px; margin:2rem auto; 
                     padding:0 2rem; }
        h2 { color:#1a1a2e; margin-bottom:1.5rem; }
        .form-card { background:white; padding:2rem;
                     border-radius:8px;
                     box-shadow:0 3px 10px rgba(0,0,0,0.1);
                     margin-bottom:2rem; }
        .form-row { display:grid;
                    grid-template-columns:1fr 1fr;
                    gap:1rem; margin-bottom:1rem; }
        .form-group { display:flex; flex-direction:column; 
                      gap:0.5rem; }
        label { font-weight:bold; color:#333; }
        input, select, textarea {
            padding:0.8rem; border:1px solid #ddd;
            border-radius:5px; font-size:1rem; }
        textarea { resize:vertical; height:80px; }
        .btn { padding:0.8rem 2rem; border:none;
               border-radius:5px; cursor:pointer;
               font-weight:bold; font-size:1rem; }
        .btn-primary { background:#667eea; color:white; 
                       width:100%; margin-top:1rem; }
        .btn-primary:hover { background:#764ba2; }
        table { width:100%; border-collapse:collapse;
                background:white; border-radius:8px;
                overflow:hidden;
                box-shadow:0 3px 10px rgba(0,0,0,0.1); }
        th { background:#1a1a2e; color:white; 
             padding:1rem; text-align:left; }
        td { padding:1rem; border-bottom:1px solid #eee; }
        tr:hover { background:#f9f9f9; }
        .btn-edit { background:#667eea; color:white;
                    padding:0.4rem 1rem; border:none;
                    border-radius:3px; cursor:pointer; }
        .btn-delete { background:#ff4757; color:white;
                      padding:0.4rem 1rem; border:none;
                      border-radius:3px; cursor:pointer;
                      margin-left:0.5rem; }
        .emoji-big { font-size:1.5rem; }
        .success { background:#2ed573; color:white;
                   padding:1rem; border-radius:5px;
                   margin-bottom:1rem; text-align:center; }
    </style>
</head>
<body>
<div class="header">
    <h1>🛒 TechStore Admin</h1>
    <a href="index.php">← View Store</a>
</div>

<div class="container">

    <?php if(isset($_GET['success'])): ?>
        <div class="success">✅ Product saved successfully!</div>
    <?php endif; ?>

    <!-- Add Product Form -->
    <div class="form-card">
        <h2>➕ Add New Product</h2>
        <form method="POST" action="store.php">
            <div class="form-row">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" 
                           placeholder="e.g. Wireless Headphones" 
                           required>
                </div>
                <div class="form-group">
                    <label>Emoji</label>
                    <input type="text" name="emoji" 
                           placeholder="e.g. 🎧" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Price (₹)</label>
                    <input type="number" name="price" 
                           placeholder="e.g. 3999" required>
                </div>
                <div class="form-group">
                    <label>Original Price (₹)</label>
                    <input type="number" name="original_price" 
                           placeholder="e.g. 4999" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="">Select category</option>
                        <option value="electronics">Electronics</option>
                        <option value="accessories">Accessories</option>
                        <option value="gadgets">Gadgets</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" 
                        placeholder="Short product description">
                    </textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                💾 Save Product
            </button>
        </form>
    </div>

    <!-- Products Table -->
    <h2>📦 All Products</h2>
    <?php
    $result = mysqli_query($conn, "SELECT * FROM products");
    ?>
    <table>
        <tr>
            <th>Emoji</th>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td class="emoji-big"><?= $row['emoji'] ?></td>
            <td><?= $row['name'] ?></td>
            <td>₹<?= $row['price'] ?></td>
            <td><?= $row['category'] ?></td>
            <td><?= $row['description'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">
                    <button class="btn-edit">✏️ Edit</button>
                </a>
                <a href="delete.php?id=<?= $row['id'] ?>"
                   onclick="return confirm(
                   'Delete this product?')">
                    <button class="btn-delete">🗑️ Delete</button>
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>