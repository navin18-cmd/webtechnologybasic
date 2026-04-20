<!DOCTYPE html>
<html>
<body>

<h2>Add Product</h2>

<form method="post">
    Name: <input type="text" name="name"><br><br>
    Price: <input type="text" name="price"><br><br>
    Description: <input type="text" name="description"><br><br>

    <input type="submit" name="submit" value="Add Product">
</form>

<?php
include("db.php");

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $sql = "INSERT INTO products (name, price, description)
            VALUES ('$name', '$price', '$description')";

    if(mysqli_query($conn, $sql)) {
        echo "Product Added!";
    } else {
        echo "Error";
    }
}
?>

</body>
</html>