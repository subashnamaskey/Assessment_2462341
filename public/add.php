<?php
	session_start();
	if (!isset($_SESSION['admin'])) {
	    header("Location: login.php");
	    exit;
	}
	
	require "../config/db.php";
	$con = dbConnect();

	$message = "";

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$name = $_POST["product_name"];
		$category = $_POST["category"];
		$price = $_POST["price"];

		if (!empty($name) && !empty($category) && !empty($price)) {

	        // 🔽 ONLY CHANGE HERE: add image column
	        $sql = "INSERT INTO products (product_name, category, price)
	                VALUES (:name, :category, :price)";

	        $stmt = $con->prepare($sql);
	        $stmt->execute([
	            ':name' => $name,
	            ':category' => $category,
	            ':price' => $price,
	        ]);

	        header("Location: index.php?added=1");
	        exit;

	    } else {
	        $message = "All fields are required!";
	    }
	}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Product | FREYA Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>Add Product</h2>

<p style="color:green;"><?php echo $message; ?></p>
<form method="POST">
	<div class="form_group">
	    <input type="text" name="product_name" placeholder="Product Name" required><br><br>

	    <select name="category" required>
	        <option value="">Select Category</option>
	        <option value="beauty_organizers">Beauty Organizers</option>
	        <option value="home_decor">Home Decors</option>
	        <option value="wedding_essentials">Wedding Essentials</option>
	        <option value="gifts">Gifts</option>
	        <option value="storage">Storage & Organizers</option>
	    </select><br><br>
	</div>
	    <input type="number" name="price" placeholder="Price" required><br><br>

    <button type="submit">Add Product</button>
</form>

</body>
</html>

