<?php
session_start();
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

require "../config/db.php";
require "../includes/functions.php";
$con = dbConnect();

// HANDLE ORDER (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_product_id'])) {
    header('Content-Type: application/json');

    $productId = $_POST['order_product_id'];

    // Fetch product details
    $stmt = $con->prepare(
        "SELECT product_name, category, price 
         FROM products 
         WHERE id = :id"
    );
    $stmt->execute([':id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }

    // 2. Insert into orders table
    $stmt = $con->prepare(
        "INSERT INTO orders 
        (product_id, product_name, category, price) 
        VALUES (:pid, :name, :category, :price)"
    );

    $stmt->execute([
        ':pid' => $productId,
        ':name' => $product['product_name'],
        ':category' => $product['category'],
        ':price' => $product['price']
    ]);

    echo json_encode(['success' => true]);
    exit;
}


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

<div class="page_wrapper">

    <div class="main_container">

    <aside class="sidebar">
        <h3>Filter Products</h3>
        <form method="GET">
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

    <section class="content">
    <div class="content_header">
        <h2>All Products</h2>
        <?php if (!empty($_SESSION['admin'])): ?>
            <button class="add_product_btn" onclick="window.location.href='add.php'">
                + Add Product
            </button>
        <?php endif; ?>
    </div>

    <div class="products_grid">
    <?php foreach ($products as $product): ?>
        <div class="product_card">
            <h4><?= htmlspecialchars($product['product_name']) ?></h4>
            <p class="price">Rs. <?= htmlspecialchars($product['price']) ?>/-</p>

    <!-- ORDER BUTTON (USERS ONLY) -->
    <?php if (!$isAdmin): ?>
        <button
            class="order_btn"
            onclick="placeOrder(<?= $product['id'] ?>)">
            Order
        </button>
    <?php endif; ?>

            <?php if (!empty($_SESSION['admin'])): ?>
                <button class="edit_product_btn"
                    onclick="window.location.href='edit.php?id=<?= $product['id'] ?>'">
                    Edit Product
                </button>

                <form method="POST" action="delete.php" class="delete_form">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <button
                        type="button"
                        class="delete_product_btn"
                        onclick="openDeleteModal(this)">
                        Delete Product
                    </button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    </div>
    </section>
    </div>
    <div id="orderModal" class="modal_overlay">
        <div class="modal_box">
            <h3>Success 🎉</h3>
            <p>Your order has been placed successfully.</p>

            <div class="modal_actions">
                <button class="confirm_btn" onclick="closeOrderModal()">OK</button>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal_overlay">
        <div class="modal_box">
            <h3>Confirm Delete</h3>
            <p>Are you sure you want to delete this product?</p>

            <div class="modal_actions">
                <button class="cancel_btn" onclick="closeDeleteModal()">Cancel</button>
                <button class="confirm_btn" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>
    <div id="orderModal" class="modal_overlay">
        <div class="modal_box">
            <h3>Success 🎉</h3>
            <p>Your order has been placed successfully.</p>

            <div class="modal_actions">
                <button class="confirm_btn" onclick="closeOrderModal()">OK</button>
            </div>
        </div>
    </div>

</div>
<script src="../assets/js/search.js"></script>


<?php include "../includes/footer.php"; ?>
