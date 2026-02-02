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
    exit;
}

include "../includes/header.php";
?>

<div class="login_container">
    <h2>Add Product</h2>

    <form method="POST">
        <input name="product_name" required placeholder="Product name" class="login_input"><br>
        <select name="category" required class="login_input">
		    <option value="">Select Category</option>
		    <option value="Home">Home</option>
		    <option value="Beauty Organizers">Beauty Organizers</option>
		    <option value="Home Decor">Home Decor</option>
		    <option value="Wedding Essentials">Wedding Essentials</option>
		    <option value="Gifts">Gifts</option>
		    <option value="Storage & Organizers">Storage & Organizers</option>
		</select><br>

        <input name="price" type="number" required placeholder="Price" class="login_input"><br>
        <button class="login_btn">Add Product</button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
