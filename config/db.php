<?php
function dbConnect(){
    $server = "mysql:host=localhost;dbname=FreyaNepal";
    $user = "root";
    $password = "";

    try {
        $con = new PDO($server, $user, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Products table only (users table created manually)
        $con->exec("
            CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_name VARCHAR(200) NOT NULL,
                category VARCHAR(200) NOT NULL,
                price INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");

        return $con;

    } catch(PDOException $e){
        die("Database connection failed: " . $e->getMessage());
    }
}
?>
