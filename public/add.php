<?php
	// echo "PHP is running";
	require "../config/db.php";
	$con = dbConnect();

	$message = "";

	if ($_SERVER["REQUEST_METHOD"]==="POST"){
		$name = $_POST["product_name"];
		$category = $_POST["category"];
		$price = $_POST["price"];

		if (!empty($name) && !empty($category) && !empty($price)) {

	        $sql = "INSERT INTO products (product_name, category, price)
	                VALUES (:name, :category, :price)"; //named placeholders to prevent SQL injection

	        $stmt = $con->prepare($sql);

	        //replacing each placeholders with actual safe value without risk of SQL injection
	        $stmt->execute([
	            ':name' => $name,
	            ':category' => $category,
	            ':price' => $price
	        ]);

	        $message = "Product added successfully!";
	        header("Location: ../public/index.php");
	        exit;


	    } else {
	        $message = "All fields are required.";
	    }
	}
?>


<!DOCTYPE html>
<html>
	<head>
	    <title>Add Product | FREYA Admin</title>
	</head>
	<body>

		<h2>Add Product</h2>

		<p style="color:green;"><?php echo $message; ?></p>

		<form method="POST">
		    <input type="text" name="product_name" placeholder="Product Name" required><br><br>

		    <select name="category" required>
		        <option value="">Select Category</option>
		        <option value="beauty_organizers">Beauty Organizers</option>
		        <option value="home_decor">Home Decor</option>
		        <option value="wedding_essentials">Wedding Essentials</option>
		        <option value="gifts">Gifts</option>
		        <option value="storage">Storage & Organizers</option>
		    </select><br><br>

		    <input type="number" name="price" placeholder="Price" required><br><br>

		    <button type="submit">Add Product</button>
		</form>

	</body>
</html>