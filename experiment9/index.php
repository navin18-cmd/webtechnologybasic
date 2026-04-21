<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TechStore</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif;
               background:#f5f5f5; color:#333; }
        header { background:linear-gradient(135deg,
                 #1a1a2e,#16213e);
                 color:white; padding:1rem 0;
                 position:sticky; top:0; z-index:100; }
        nav { display:flex; justify-content:space-between;
              align-items:center; max-width:1200px;
              margin:0 auto; padding:0 2rem; }
        .logo { font-size:1.8rem; font-weight:bold;
                color:#00d4ff; }
        nav ul { display:flex; list-style:none; gap:2rem; }
        nav a { color:white; text-decoration:none; }
        nav a:hover { color:#00d4ff; }
        .hero { background:linear-gradient(135deg,
                #667eea,#764ba2);
                color:white; padding:4rem 2rem;
                text-align:center; }
        .hero h1 { font-size:2.5rem; margin-bottom:1rem; }
        .hero p { font-size:1.1rem; }
        .filters { max-width:1200px; margin:2rem auto;
                   padding:0 2rem; display:flex;
                   gap:1rem; justify-content:center;
                   flex-wrap:wrap; }
        .filter-btn { padding:0.5rem 1.5rem;
                      border:2px solid #ddd;
                      background:white; border-radius:25px;
                      cursor:pointer; transition:all 0.3s; }
        .filter-btn.active { background:#667eea;
                             color:white;
                             border-color:#667eea; }
        .products-section { max-width:1200px;
                            margin:2rem auto; padding:0 2rem; }
        .products-title { font-size:2rem; margin-bottom:2rem;
                          color:#1a1a2e; }
        .products-grid { display:grid;
            grid-template-columns:repeat(
                auto-fill,minmax(250px,1fr));
            gap:2rem; }
        .product-card { background:white; border-radius:8px;
                        overflow:hidden;
                        box-shadow:0 3px 10px rgba(0,0,0,0.1);
                        transition:transform 0.3s; }
        .product-card:hover { transform:translateY(-5px); }
        .product-emoji { font-size:4rem; text-align:center;
                         padding:2rem; background:#f0f0f0; }
        .product-info { padding:1.5rem; }
        .product-name { font-size:1.2rem; font-weight:bold;
                        margin-bottom:0.5rem; color:#1a1a2e; }
        .product-description { color:#666; font-size:0.9rem;
                               margin-bottom:1rem; }
        .product-price-section { display:flex;
                                  justify-content:space-between;
                                  align-items:center;
                                  margin-bottom:1rem; }
        .product-price { font-size:1.5rem; font-weight:bold;
                         color:#667eea; }
        .original-price { text-decoration:line-through;
                          color:#999; font-size:0.9rem; }
        .discount { background:#ff4757; color:white;
                    padding:0.3rem 0.8rem; border-radius:20px;
                    font-size:0.8rem; font-weight:bold; }
        .add-to-cart-btn { width:100%; padding:0.8rem;
                           background:#667eea; color:white;
                           border:none; border-radius:5px;
                           cursor:pointer; font-weight:bold; }
        .add-to-cart-btn:hover { background:#764ba2; }
        .admin-link { text-align:center; margin:1rem; }
        .admin-link a { color:#667eea; text-decoration:none;
                        font-weight:bold; }
        footer { background:#1a1a2e; color:white;
                 text-align:center; padding:2rem;
                 margin-top:4rem; }
    </style>
</head>
<body>

<header>
    <nav>
        <div class="logo">🛒 TechStore</div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="admin.php">Admin</a></li>
        </ul>
    </nav>
</header>

<div class="hero">
    <h1>Welcome to TechStore</h1>
    <p>Discover the latest products at unbeatable prices</p>
</div>

<div class="filters">
    <button class="filter-btn active" 
            onclick="window.location='index.php'">
        All Products
    </button>
    <button class="filter-btn"
        onclick="window.location=
        'index.php?category=electronics'">
        Electronics
    </button>
    <button class="filter-btn"
        onclick="window.location=
        'index.php?category=accessories'">
        Accessories
    </button>
    <button class="filter-btn"
        onclick="window.location=
        'index.php?category=gadgets'">
        Gadgets
    </button>
</div>

<section class="products-section">
    <h2 class="products-title">Featured Products</h2>
    <div class="products-grid">
        <?php
        $category = isset($_GET['category']) 
                    ? $_GET['category'] : '';

        if($category) {
            $result = mysqli_query($conn, 
                "SELECT * FROM products 
                 WHERE category='$category'");
        } else {
            $result = mysqli_query($conn, 
                "SELECT * FROM products");
        }

        while($row = mysqli_fetch_assoc($result)):
            $discount = round((($row['original_price'] 
                        - $row['price']) / 
                        $row['original_price']) * 100);
        ?>
        <div class="product-card">
            <div class="product-emoji">
                <?= $row['emoji'] ?>
            </div>
            <div class="product-info">
                <div class="product-name">
                    <?= $row['name'] ?>
                </div>
                <div class="product-description">
                    <?= $row['description'] ?>
                </div>
                <div class="product-price-section">
                    <div>
                        <div class="product-price">
                            ₹<?= $row['price'] ?>
                        </div>
                        <div class="original-price">
                            ₹<?= $row['original_price'] ?>
                        </div>
                    </div>
                    <div class="discount">
                        -<?= $discount ?>%
                    </div>
                </div>
                <button class="add-to-cart-btn">
                    🛒 Add to Cart
                </button>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<footer>
    <p>© 2026 TechStore. All rights reserved.</p>
</footer>

</body>
</html>