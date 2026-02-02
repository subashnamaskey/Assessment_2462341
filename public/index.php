<?php
session_start();
require "../config/db.php";
$con = dbConnect();

$stmt = $con->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "../includes/header.php";
?>

<div class="main_container">

<aside class="sidebar">
    <h3>Filter Products</h3>

    <label>Category</label>
    <select>
        <option>All Categories</option>
    </select>

    <label>Price Range</label>
    <select>
        <option>All Prices</option>
    </select>
</aside>

<section class="content">

<div class="content_header">
    <h2>All Products</h2>

    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
        <button class="add_product_btn"
                onclick="window.location.href='add.php'">
            + Add Product
        </button>
    <?php endif; ?>
</div>

<div class="products_grid">
<?php foreach ($products as $product): ?>
    <div class="product_card">
        <h4><?= htmlspecialchars($product['product_name']) ?></h4>
        <p class="price">Rs. <?= htmlspecialchars($product['price']) ?>/-</p>

        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
            <button
                class="edit_product_btn"
                onclick="window.location.href='edit.php?id=<?= $product['id'] ?>'">
                Edit Product
            </button>

            <button
                class="delete_product_btn"
                onclick="if(confirm('Are you sure?')) window.location.href='delete.php?id=<?= $product['id'] ?>'">
                Delete Product
            </button>

        <?php endif; ?>
    </div>
<?php endforeach; ?>
</div>

</section>
</div>

<?php include "../includes/footer.php"; ?>
