<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require "../config/db.php";
$con = dbConnect();

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $con->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $con->prepare(
        "UPDATE products 
         SET product_name = :n, category = :c, price = :p 
         WHERE id = :id"
    );

    $stmt->execute([
        ':n' => $_POST['product_name'],
        ':c' => $_POST['category'],
        ':p' => $_POST['price'],
        ':id' => $id
    ]);

    header("Location: index.php");
    exit;
}

include "../includes/header.php";
?>

<div class="login_container">
    <h2>Edit Product</h2>

    <form method="POST">
        <input
            name="product_name"
            class="login_input"
            value="<?= htmlspecialchars($product['product_name']) ?>"
            required
        ><br>

        <select name="category" required class="login_input">
            <option value="Home" <?= ($product['category']=='Home')?'selected':'' ?>>Home</option>
            <option value="Beauty Organizers" <?= ($product['category']=='Beauty Organizers')?'selected':'' ?>>Beauty Organizers</option>
            <option value="Home Decor" <?= ($product['category']=='Home Decor')?'selected':'' ?>>Home Decor</option>
            <option value="Wedding Essentials" <?= ($product['category']=='Wedding Essentials')?'selected':'' ?>>Wedding Essentials</option>
            <option value="Gifts" <?= ($product['category']=='Gifts')?'selected':'' ?>>Gifts</option>
            <option value="Storage & Organizers" <?= ($product['category']=='Storage & Organizers')?'selected':'' ?>>Storage & Organizers</option>
        </select><br>

        <input
            name="price"
            type="number"
            class="login_input"
            value="<?= htmlspecialchars($product['price']) ?>"
            required
        ><br>

        <button class="login_btn">Update Product</button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
