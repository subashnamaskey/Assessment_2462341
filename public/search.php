<?php
    session_start();
    require "../config/db.php";
    $con = dbConnect();

    $keyword = $_GET['q'] ?? '';

    // AJAX Handler
    if (isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        
        if (strlen($keyword) < 2) {
            echo json_encode([]);
            exit;
        }

        try {
            $stmt = $con->prepare(
                "SELECT id, product_name 
                 FROM products 
                 WHERE product_name LIKE :keyword 
                 OR category LIKE :keyword 
                 LIMIT 5"
            );
            $stmt->execute([':keyword' => "%$keyword%"]);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
        exit;
    }

    // Normal Page Handler
    $stmt = $con->prepare(
        "SELECT * FROM products 
         WHERE product_name LIKE :keyword 
         OR category LIKE :keyword"
    );

    $stmt->execute([
        ':keyword' => "%$keyword%"
    ]);

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include "../includes/header.php";
?>

<!-- MAIN CONTENT -->
<div class="main_container">
    <section class="content" style="width: 100%;">
        <div class="content_header">
            <h2>Search Results for "<?= htmlspecialchars($keyword) ?>"</h2>
        </div>

        <div class="products_grid">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="product_card">
                    <h4><?= htmlspecialchars($product['product_name']) ?></h4>
                    <p class="price">Rs. <?= htmlspecialchars($product['price']) ?>/-</p>

                    <!-- ADMIN ONLY ACTIONS -->
                    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                        <div class="admin_actions">
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

                        </div>
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
