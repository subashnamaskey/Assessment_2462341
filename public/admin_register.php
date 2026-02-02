<?php
require "../config/db.php";
$con = dbConnect();
$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $con->prepare(
            "INSERT INTO users (username, password, role)
             VALUES (:u, :p, 'admin')"
        );
        $stmt->execute([
            ':u' => $username,
            ':p' => $password
        ]);
        $msg = "Admin registered successfully";
    } catch (PDOException $e) {
        $msg = "Username already exists";
    }
}
?>

<h2>Admin Register</h2>
<p><?= $msg ?></p>

<form method="POST">
    <input name="username" required placeholder="Username"><br><br>
    <input type="password" name="password" required placeholder="Password"><br><br>
    <button type="submit">Register</button>
</form>
