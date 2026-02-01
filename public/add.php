<?php
	require "../config/db.php";
	$con = dbConnect();

	$message = "";

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$name = $_POST["product_name"];
		$category = $_POST["category"];
		$price = $_POST["price"];

		// Image handling
		$image = $_FILES["product_image"];
		$ext = pathinfo($image["name"], PATHINFO_EXTENSION);
		$imageName = time() . "." . $ext;
		$targetPath = "../assets/" . $imageName;


		if (!empty($name) && !empty($category) && !empty($price) && $image["error"] === UPLOAD_ERR_OK) {

			move_uploaded_file($image["tmp_name"], $targetPath);

	        // 🔽 ONLY CHANGE HERE: add image column
	        $sql = "INSERT INTO products (product_name, category, price, image)
	                VALUES (:name, :category, :price, :image)";

	        $stmt = $con->prepare($sql);
	        $stmt->execute([
	            ':name' => $name,
	            ':category' => $category,
	            ':price' => $price,
	            ':image' => $imageName
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

<p style="color:green;"><?php echo $message; ?></p>		<form method="POST" enctype="multipart/form-data">
	
	<div class="img_upload">
		<label for="product_image" class="file_label">Upload Product Image</label>
		<input type="file" id="product_image" name="product_image" accept="image/*" hidden required>
	</div>
	<img id="preview" style="display:none; width:200px; margin-bottom:15px;">

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

<script>
document.getElementById("product_image").addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
        const preview = document.getElementById("preview");
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    }
});
</script>

