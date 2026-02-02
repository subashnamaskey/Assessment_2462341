<?php
require "../config/db.php";
$con = dbConnect();

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $con->prepare(
                "INSERT INTO users (username, password, role)
                 VALUES (:u, :p, 'admin')"
            );

            $stmt->execute([
                ':u' => $username,
                ':p' => $hashedPassword
            ]);

            $msg = "Admin registered successfully. You can now login.";

        } catch (PDOException $e) {
            $msg = "Username already exists.";
        }

    } else {
        $msg = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Register | FREYA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="login_container">
    <h2>Admin Registration</h2>

    <p style="color:green;"><?= htmlspecialchars($msg) ?></p>

    <form method="POST">
        <input
            type="text"
            name="username"
            class="login_input"
            placeholder="Username"
            required
        ><br>

        <input
            type="password"
            name="password"
            class="login_input"
            placeholder="Password"
            required
        ><br>

        <button type="submit" class="login_btn">Register Admin</button>
    </form>

    <br>
    <a href="login.php" class="register_link">Back to Login</a>
</div>

</body>
</html>
