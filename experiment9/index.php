<?php
$conn = mysqli_connect(
    "sql205.infinityfree.com",
    "if0_41650060",
    "gsnavin1234",
    "if0_41650060_techstore"
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
        }

        h1 {
            text-align: center;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .emoji {
            font-size: 60px;
        }

        .price {
            color: green;
            font-weight: bold;
        }

        .top-link {
            text-align: center;
            margin: 10px;
        }
    </style>
</head>

<body>

<h1>🛒 TechStore</h1>

<div class="top-link">
    <a href="add_product.php">➕ Add Product</a>
</div>

<div class="grid">

<?php
$result = mysqli_query($conn, "SELECT * FROM products");

while ($row = mysqli_fetch_assoc($result)) {
?>

    <div class="card">

        <div class="emoji">🛍️</div>

        <h3><?php echo $row['name']; ?></h3>
        <p><?php echo $row['description']; ?></p>
        <p class="price">₹<?php echo $row['price']; ?></p>
    </div>

<?php
}
?>

</div>

</body>
</html>