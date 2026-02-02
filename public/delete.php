<?php
session_start();
if (!isset($_SESSION['admin'])) exit;

require "../config/db.php";
require "../includes/functions.php";
$con = dbConnect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $stmt = $con->prepare("DELETE FROM products WHERE id = :id");
    $stmt->execute([':id' => $_POST['id']]);
}

header("Location: index.php");
exit;
