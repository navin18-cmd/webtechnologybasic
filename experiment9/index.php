<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - Your Online Tech Shop</title>
    <link rel="stylesheet" href="e-commerce.css">
</head>
<body>

<header>
    <nav>
        <div class="logo">🛒 TechStore</div>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#products">Products</a></li>
            <li><a href="add_product.php">Add Product</a></li>
        </ul>
    </nav>
</header>

<section class="hero" id="home">
    <h1>Welcome to TechStore</h1>
    <p>Dynamic Product Display using PHP & MySQL</p>
</section>

<section class="products-section" id="products">
    <h2 class="products-title">Products</h2>

    <div class="products-grid">

    <?php
    // DB CONNECTION
    $conn = mysqli_connect(
        "sql205.infinityfree.com",
        "if0_41650060",
        "gsnavin1234",
        "if0_41650060_techstore"
    );

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // FETCH DATA
    $result = mysqli_query($conn, "SELECT * FROM products");

    while($row = mysqli_fetch_assoc($result)) {
    ?>

        <div class="product-card">
            <div class="product-image">🛍️</div>

            <div class="product-info">
                <div class="product-name">
                    <?php echo $row['name']; ?>
                </div>

                <div class="product-description">
                    <?php echo $row['description']; ?>
                </div>

                <div class="product-price">
                    ₹<?php echo $row['price']; ?>
                </div>
            </div>
        </div>

    <?php } ?>

    </div>
</section>

<footer>
    <p style="text-align:center;">© 2026 TechStore</p>
</footer>

</body>
</html>