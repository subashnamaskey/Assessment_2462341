<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FREYA | All Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="page_wrapper">

        <!-- NAVBAR -->
        <nav class="navbar">
            <div class="nav_container">
                <h2 class="logo">FREYA</h2>
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

                    <!-- SORT BY -->

                    <select>
                        <option value="">Sort by:</option>
                        <option value="new">New Products</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                    </select>
                </div>

                <!-- PRODUCTS GRID -->

                <div class="products_grid">
                    
                    <div class="product_card">
                        <!-- <img src="" alt="brushholder"> -->
                        <h4>Acrylic Dust Free Brush Holder</h4>
                        <p class="price">Rs. 1999/-</p>
                    </div>

                    <div class="product_card">
                        <!-- <img src="assets/images/makeup-organizer.jpg" alt=""> -->
                        <h4>Two-Tier Makeup Organizer</h4>
                        <p class="price">Rs. 3,499</p>
                    </div>

                    <div class="product_card">
                        <!-- <img src="assets/images/crystal-lamp.jpg" alt=""> -->
                        <h4>Crystal Touch Mood Lamp</h4>
                        <p class="price">Rs. 2,499</p>
                    </div>

                    <div class="product_card">
                        <!-- <img src="assets/images/gift-bag.jpg" alt=""> -->
                        <h4>Luxury Gift Bag Set</h4>
                        <p class="price">Rs. 1,299</p>
                    </div>

                    <div class="product_card">
                        <!-- <img src="assets/images/wall-decor.jpg" alt=""> -->
                        <h4>Metal Wall Decor (Premium)</h4>
                        <p class="price">Rs. 4,999</p>
                    </div>

                    <div class="product_card">
                        <!-- <img src="assets/images/storage-box.jpg" alt=""> -->
                        <h4>Aesthetic Storage Box</h4>
                        <p class="price">Rs. 2,199</p>
                    </div>

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
