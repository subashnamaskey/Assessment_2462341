<?php
	function dbConnect(){
		$server = "mysql:host=localhost;dbname=FreyaNepal";
		$user = "root";
		$password = "";
		try{
			$con = new PDO($server, $user, $password);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$con->exec("CREATE TABLE IF NOT EXISTS products(id INT AUTO_INCREMENT PRIMARY KEY, product_name varchar(200) NOT NULL, category varchar(200) NOT NULL, price INT NOT NULL, image varchar(255), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP )");
			// echo "Table Created Successfully";
			return $con;
		}catch(PDOException $e){
			die("Connection Failed: ".$e->getMessage());
		}
	}
?>
