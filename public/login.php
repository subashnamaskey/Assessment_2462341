<?php
session_start();
require "../config/db.php";
$con = dbConnect();
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $con->prepare(
        "SELECT * FROM users WHERE username = :u AND role = 'admin'"
    );
    $stmt->execute([':u' => $_POST['username']]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($_POST['password'], $admin['password'])) {
        $_SESSION['admin'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid login";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login | FREYA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div style="width: 300px; margin: 50px auto; text-align: center;">
    <h2>Admin Login</h2>
    <p style="color:red"><?= $error ?></p>

    <form method="POST">
        <input type="text" name="username" required placeholder="Username" style="padding: 8px; width: 100%; margin-bottom: 10px;"><br>
        <input type="password" name="password" required placeholder="Password" style="padding: 8px; width: 100%; margin-bottom: 10px;"><br>
        <button type="submit" class="add_product_btn" style="width: 100%;">Login</button>
    </form>

    <br>
    <p>Don't have an account?</p>
    <a href="admin_register.php" style="color: #925a5b; font-weight: bold;">Register New Admin</a>
</div>

</body>
</html>