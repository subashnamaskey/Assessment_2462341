<?php
    require "../config/db.php";
    $con = dbConnect();

    $keyword = $_GET['q'] ?? '';

    $stmt = $con->prepare(
        "SELECT * FROM products 
         WHERE product_name LIKE :keyword 
         OR category LIKE :keyword"
    );

    $stmt->execute([
        ':keyword' => "%$keyword%"
    ]);

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search | FREYA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>Search Results</h2>

<form method="GET">
    <input type="text" name="q" placeholder="Search products..." value="<?= htmlspecialchars($keyword) ?>">
    <button type="submit">Search</button>
</form>

<br>

<div class="products_grid">
<?php if (count($products) > 0): ?>
    <?php foreach ($products as $product): ?>
        <div class="product_card">
            <h4><?= htmlspecialchars($product['product_name']) ?></h4>
            <p class="price">Rs. <?= htmlspecialchars($product['price']) ?>/-</p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>
</div>

</body>
</html>
