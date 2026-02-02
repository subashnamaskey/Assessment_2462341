<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require "../config/db.php";
$con = dbConnect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $con->prepare(
        "INSERT INTO products (product_name, category, price)
         VALUES (:n, :c, :p)"
    );
    $stmt->execute([
        ':n' => $_POST['product_name'],
        ':c' => $_POST['category'],
        ':p' => $_POST['price']
    ]);
    header("Location: index.php");
}
?>

<form method="POST">
    <input name="product_name" required placeholder="Product name"><br>
    <input name="category" required placeholder="Category"><br>
    <input name="price" type="number" required placeholder="Price"><br>
    <button>Add</button>
</form>
