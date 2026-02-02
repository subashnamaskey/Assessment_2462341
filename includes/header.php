<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FREYA | All Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/style.css?v=2">
    <script src="../assets/js/search.js" defer></script>
</head>
<body>
<div class="page_wrapper">

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav_container">

        <!-- TOP ROW -->
        <div class="nav_top">
            <h2 class="logo">FREYA</h2>

            <div class="nav_search" style="position: relative;">
                <input
                    type="text"
                    id="searchInput"
                    name="q"
                    placeholder="Search products"
                    autocomplete="off"
                >

                <button
                    type="button"
                    onclick="window.location.href='search.php?q=' + document.getElementById('searchInput').value">
                    Search
                </button>

                <div
                    id="searchSuggestions"
                    class="search_suggestions"
                    style="display:none; position:absolute; top:100%; left:0; right:0; background:#fff; border:1px solid #ccc; z-index:1000;">
                </div>
            </div>

            <!-- LOGIN / LOGOUT (TOP RIGHT) -->
            <div style="margin-left:auto;">
                <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                    <a
                        href="logout.php"
                        class="add_product_btn"
                        style="margin-left:10px;">
                        Logout
                    </a>
                <?php else: ?>
                    <a
                        href="login.php"
                        class="add_product_btn"
                        style="margin-left:10px;">
                        Admin Login
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- BOTTOM ROW -->
        <ul class="nav_links">
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?category=Beauty%20Organizers">Beauty Organizers</a></li>
            <li><a href="index.php?category=Home%20Decor">Home Decor</a></li>
            <li><a href="index.php?category=Wedding%20Essentials">Wedding Essentials</a></li>
            <li><a href="index.php?category=Gifts">Gifts</a></li>
            <li><a href="index.php?category=Storage%20%26%20Organizers">Storage & Organizers</a></li>
        </ul>


    </div>
</nav>
