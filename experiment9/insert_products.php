<?php
include 'db.php';

// Clear old data (optional)
$conn->query("DELETE FROM products");

$products = [
    ["Wireless Headphones", 3999, 4999, "electronics", "Premium wireless headphones", "headphone.png"],
    ["PS5 Console", 60000, 70000, "gadgets", "Next-gen console", "PS5.png"],
    ["Nike Shoes", 12999, 15999, "accessories", "Comfortable sneakers", "Nike shoes.png"],
    ["Men Accessories", 599, 799, "accessories", "Stylish essentials", "Men Accessories.png"],
    ["Alba Watch", 29999, 35999, "gadgets", "Classic watch", "ALBA watch (1).png"],
    ["RC Car", 7999, 8999, "accessories", "Remote car", "RC Car.png"],
    ["MRF Bat", 14999, 18999, "sports", "Cricket bat", "MRF bat.png"],
    ["Racket", 8999, 10999, "sports", "Badminton racket", "Racket.png"],
    ["Plant Decor", 399, 599, "home", "Indoor plant decor", "Plant decor.png"]
];

foreach ($products as $p) {
    $name = $p[0];
    $price = $p[1];
    $originalPrice = $p[2];
    $category = $p[3];
    $description = $p[4];
    $image = $p[5];

    $sql = "INSERT INTO products (name, price, originalPrice, category, description, image)
            VALUES ('$name', '$price', '$originalPrice', '$category', '$description', '$image')";

    $conn->query($sql);
}

echo "All products inserted successfully!";
?>