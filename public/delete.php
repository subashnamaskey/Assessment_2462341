<?php
session_start();
if (!isset($_SESSION['admin'])) exit;

require "../config/db.php";
$con = dbConnect();

$stmt = $con->prepare("DELETE FROM products WHERE id = :id");
$stmt->execute([':id' => $_GET['id']]);

header("Location: index.php");
