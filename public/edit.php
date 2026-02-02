<?php
session_start();
if (!isset($_SESSION['admin'])) exit;

require "../config/db.php";
$con = dbConnect();

$id = $_GET['id'];

$stmt = $con->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $con->prepare(
        "UPDATE products SET product_name=:n, category=:c, price=:p WHERE id=:id"
    );
    $stmt->execute([
        ':n' => $_POST['product_name'],
        ':c' => $_POST['category'],
        ':p' => $_POST['price'],
        ':id' => $id
    ]);
    header("Location: index.php");
}
?>

<form method="POST">
    <input name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>"><br>
    <input name="category" value="<?= htmlspecialchars($product['category']) ?>"><br>
    <input name="price" value="<?= htmlspecialchars($product['price']) ?>"><br>
    <button>Update</button>
</form>
