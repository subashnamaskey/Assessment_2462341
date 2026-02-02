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

<div class="login_container">
    <h2>Admin Login</h2>
    <p class="error_msg"><?= $error ?></p>

    <form method="POST">
        <input type="text" name="username" required placeholder="Username" class="login_input"><br>
        <input type="password" name="password" required placeholder="Password" class="login_input"><br>
        <button type="submit" class="login_btn">Login</button>
    </form>

    <br>
    <p>Don't have an account?</p>
    <a href="admin_register.php" class="register_link">Register New Admin</a>
</div>

</body>
</html>