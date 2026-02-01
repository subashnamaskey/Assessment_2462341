<?php
    require "../config/db.php";
    $con = dbConnect();

    if (!isset($_GET['id'])) {
        header("Location: index.php");
        exit;
    }

    $id = $_GET['id'];
    $message = "";

    // Fetch existing product
    $stmt = $con->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        header("Location: index.php");
        exit;
    }

    // Update product
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST["product_name"];
        $category = $_POST["category"];
        $price = $_POST["price"];

        if (!empty($name) && !empty($category) && !empty($price)) {

            $sql = "UPDATE products 
                    SET product_name = :name, category = :category, price = :price 
                    WHERE id = :id";

            $stmt = $con->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':category' => $category,
                ':price' => $price,
                ':id' => $id
            ]);

            header("Location: index.php?updated=1");
            exit;
        } else {
            $message = "All fields are required!";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product | FREYA Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>Edit Product</h2>

<p style="color:green;"><?php echo $message; ?></p>

<form method="POST">
    <input type="text" name="product_name"
           value="<?= htmlspecialchars($product['product_name']) ?>" required><br><br>

    <select name="category" required>
        <option value="">Select Category</option>
        <option value="beauty_organizers" <?= $product['category']=="beauty_organizers"?"selected":"" ?>>Beauty Organizers</option>
        <option value="home_decor" <?= $product['category']=="home_decor"?"selected":"" ?>>Home Decors</option>
        <option value="wedding_essentials" <?= $product['category']=="wedding_essentials"?"selected":"" ?>>Wedding Essentials</option>
        <option value="gifts" <?= $product['category']=="gifts"?"selected":"" ?>>Gifts</option>
        <option value="storage" <?= $product['category']=="storage"?"selected":"" ?>>Storage & Organizers</option>
    </select><br><br>

    <input type="number" name="price"
           value="<?= htmlspecialchars($product['price']) ?>" required><br><br>

    <button type="submit">Update Product</button>
</form>

</body>
</html>

