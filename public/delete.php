<?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
        exit;
    }
    
    require "../config/db.php";
    $con = dbConnect();

    /* 1. Check if ID exists */
    if (!isset($_GET['id'])) {
        header("Location: index.php");
        exit;
    }

    $id = $_GET['id'];

    /* 2. Delete product */
    $stmt = $con->prepare("DELETE FROM products WHERE id = :id");
    $stmt->execute([':id' => $id]);

    /* 3. Redirect back */
    header("Location: index.php?deleted=1");
    exit;
