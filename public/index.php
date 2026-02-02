<?php
session_start();
require "../config/db.php";
$con = dbConnect();

/* GET FILTER VALUES */
$category = $_GET['category'] ?? 'all';
$price = $_GET['price'] ?? 'all';
$search = $_GET['q'] ?? '';

$query = "SELECT * FROM products WHERE 1";
$params = [];

/* SEARCH FILTER */
if (!empty($search)) {
    $query .= " AND (product_name LIKE :search OR category LIKE :search)";
    $params[':search'] = "%$search%";
}

/* CATEGORY FILTER */
if ($category !== 'all') {
    $query .= " AND category = :category";
    $params[':category'] = $category;
}

/* PRICE FILTER */
if ($price !== 'all') {
    if ($price === '0-1000') {
        $query .= " AND price BETWEEN 0 AND 1000";
    } elseif ($price === '1000-2500') {
        $query .= " AND price BETWEEN 1000 AND 2500";
    } elseif ($price === '2500-3500') {
        $query .= " AND price BETWEEN 2500 AND 3500";
    }
}

$stmt = $con->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "../includes/header.php";
?>

<div class="main_container">

<!-- SIDEBAR -->
<aside class="sidebar">
    <h3>Filter Products</h3>

    <form method="GET">

        <!-- KEEP SEARCH WHEN FILTERING -->
        <?php if (!empty($search)): ?>
            <input type="hidden" name="q" value="<?= htmlspecialchars($search) ?>">
        <?php endif; ?>

        <label>Category</label>
        <select name="category" onchange="this.form.submit()">
            <option value="all">All Categories</option>
            <option value="Home" <?= ($category=='Home')?'selected':'' ?>>Home</option>
            <option value="Beauty Organizers" <?= ($category=='Beauty Organizers')?'selected':'' ?>>Beauty Organizers</option>
            <option value="Home Decor" <?= ($category=='Home Decor')?'selected':'' ?>>Home Decor</option>
            <option value="Wedding Essentials" <?= ($category=='Wedding Essentials')?'selected':'' ?>>Wedding Essentials</option>
            <option value="Gifts" <?= ($category=='Gifts')?'selected':'' ?>>Gifts</option>
            <option value="Storage & Organizers" <?= ($category=='Storage & Organizers')?'selected':'' ?>>Storage & Organizers</option>
        </select>

        <label>Price Range</label>
        <select name="price" onchange="this.form.submit()">
            <option value="all">All Prices</option>
            <option value="0-1000" <?= ($price=='0-1000')?'selected':'' ?>>Rs. 0 – 1000</option>
            <option value="1000-2500" <?= ($price=='1000-2500')?'selected':'' ?>>Rs. 1000 – 2500</option>
            <option value="2500-3500" <?= ($price=='2500-3500')?'selected':'' ?>>Rs. 2500 – 3500</option>
        </select>

    </form>
</aside>

<!-- CONTENT -->
<section class="content">

<div class="content_header">
    <h2>All Products</h2>

    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
        <button class="add_product_btn" onclick="window.location.href='add.php'">
            + Add Product
        </button>
    <?php endif; ?>
</div>

<div class="products_grid">
<?php if (count($products) > 0): ?>
    <?php foreach ($products as $product): ?>
        <div class="product_card">
            <h4><?= htmlspecialchars($product['product_name']) ?></h4>
            <p class="price">Rs. <?= htmlspecialchars($product['price']) ?>/-</p>

            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                <button class="edit_product_btn"
                    onclick="window.location.href='edit.php?id=<?= $product['id'] ?>'">
                    Edit Product
                </button>

                <button class="delete_product_btn"
                    onclick="if(confirm('Are you sure?')) window.location.href='delete.php?id=<?= $product['id'] ?>'">
                    Delete Product
                </button>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>
</div>

</section>
</div>

<?php include "../includes/footer.php"; ?>
