<?php
    require "../config/db.php";
    $con = dbConnect();

    if (!isset($_GET['id'])) {
        header("Location: index.php");
        exit;
    }

    $id = $_GET['id'];

    $stmt = $con->prepare("DELETE FROM products WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header("Location: index.php?deleted=1");
    exit;
?>
