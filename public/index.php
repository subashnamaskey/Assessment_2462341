<?php
    session_start();
    // $_SESSION['is_admin'] = true;
    require '../config/db.php';
    $con = dbConnect();
    $stmt = $con->prepare("SELECT * FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FREYA | All Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body>
    <div class="page_wrapper">

        <!-- NAVBAR -->
        <nav class="navbar">
            <div class="nav_container">

                <!-- TOP ROW -->
                <div class="nav_top">
                    <h2 class="logo">FREYA</h2>

                    <form action="search.php" method="GET" class="nav_search">
                        <input type="text" name="q" placeholder="Search products">
                        <button type="submit">Search</button>
                    </form>
                </div>

                <!-- BOTTOM ROW -->
                <ul class="nav_links">
                    <li>Home</li>
                    <li>Beauty Organizers</li>
                    <li>Home Decor</li>
                    <li>Wedding Essentials</li>
                    <li>Gifts</li>
                    <li>Storage & Organizers</li>
                </ul>

            </div>
        </nav>


        <!-- MAIN CONTENTS -->

        <div class="main_container">
            

            <!-- FILTER SIDEBAR -->

            <aside class="sidebar">
                <h3>Filter Products</h3>


                <!-- CATEGORY FILTER -->

                <label>Category</label>
                <select>
                    <option value="">All Categories</option>
                    <option value="beauty_organizers">Beauty Organizers</option>
                    <option value="home_decor">Home Decor</option>
                    <option value="wedding_essentials">Wedding Essentials</option>
                    <option value="gifts">Gifts</option>
                    <option value="storage">Storage & Organizers</option>
                </select>


                <!-- PRICE FILTER -->

                <label>Price Range</label>
                <select>
                    <option class="">All Prices</option>
                    <option class="0-1000">Under Rs. 1000/-</option>
                    <option class="1000-2500">Under Rs. 2000/-</option>
                    <option class="2500-5000">Under Rs. 5000/-</option>
                </select>
            </aside>


            <!-- PRODUCTS SECTION -->

            <section class="content">
                
            <!-- HEADER -->

                <div class="content_header">
                    <h2>All Products</h2>

                    <div class="sort_actions">
                        
                        <!-- SORT BY -->

                        <select>
                            <option value="">Sort by:</option>
                            <option value="new">New Products</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                        </select>

                        <!-- ADD PRODUCT (ADMIN ONLY) -->

                        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                            <button class="add_product_btn" onclick="window.location.href='add.php'">+ Add Product</button>
                            <button class="add_product_btn" onclick="window.location.href='logout.php'">Logout</button>
                        <?php endif; ?>


                    </div>
                </div>

                <!-- PRODUCTS GRID -->

                <div class="products_grid">
                    
                    <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product_card">

                            <h4><?= htmlspecialchars($product['product_name']) ?></h4>
                            <p class="price">Rs. <?= htmlspecialchars($product['price']) ?>/-</p>

                            <!-- ADMIN ONLY ACTIONS -->
                            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                                <div class="admin_actions">
                                    <button class="edit_product_btn"
                                            onclick="window.location.href='edit.php?id=<?= $product['id'] ?>'">Edit Product
                                    </button>

                                    <button class="delete_product_btn"
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
    </div>
<!-- ===== FOOTER ===== -->
<footer class="footer">
    <p>&copy; 2023 FREYA Nepal </p>
</footer>

</body>
</html>
