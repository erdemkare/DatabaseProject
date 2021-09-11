<!DOCTYPE html>
<html>
<body>
<form method="post">
    <br/><input type="submit" name="ins" id="ins" value="Install" /><br/>
</form>
<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
function inst()
{
	$servername = "localhost";
	$username = "root";
	$password = "mysql";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	} 
	// sql to create table
	$sql = "DROP DATABASE IF EXISTS erdem_erdem";
	$result = mysqli_query($conn,$sql) or die("Error");
	$sql = "CREATE DATABASE erdem_erdem";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));
	$sql = "USE erdem_erdem";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

	$sql = "CREATE TABLE IF NOT EXISTS district (
	district_name varchar(50) NOT NULL,
	PRIMARY KEY(district_name)
	) ENGINE=InnoDB";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

	$sql = "CREATE TABLE IF NOT EXISTS city (
	city_name varchar(50) NOT NULL,
	district_name varchar(50) NOT NULL,
	PRIMARY KEY(city_name),
	FOREIGN KEY fk_city_district_name (district_name) REFERENCES district (district_name)
	) ENGINE=InnoDB";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

	$sql = "CREATE TABLE IF NOT EXISTS branch (
	branch_id int(11) NOT NULL AUTO_INCREMENT,
	branch_name varchar(50) NOT NULL,
	city_name varchar(50) NOT NULL,
	PRIMARY KEY(branch_id),
	FOREIGN KEY fk_branch_city_name (city_name) REFERENCES city (city_name)
	) ENGINE=InnoDB";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

	$sql = "CREATE TABLE IF NOT EXISTS salesman (
	salesman_id int(11) NOT NULL AUTO_INCREMENT,
	salesman_name varchar(50) NOT NULL,
	branch_id int(11) NOT NULL,
	PRIMARY KEY(salesman_id),
	FOREIGN KEY fk_salesman_branch_id (branch_id) REFERENCES branch (branch_id)
	) ENGINE=InnoDB";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

	$sql = "CREATE TABLE IF NOT EXISTS book (
	book_id int(11) NOT NULL AUTO_INCREMENT,
	book_name varchar(50) NOT NULL,
	price double DEFAULT 0,
	PRIMARY KEY(book_id)
	) ENGINE=InnoDB";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

	$sql = "CREATE TABLE IF NOT EXISTS customer (
	customer_id int(11) NOT NULL AUTO_INCREMENT,
	customer_name varchar(50) NOT NULL,
	PRIMARY KEY(customer_id)
	) ENGINE=InnoDB";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

	$sql = "CREATE TABLE IF NOT EXISTS sale (
	sale_id int(11) NOT NULL AUTO_INCREMENT,
	book_id int(11) NOT NULL,
	salesman_id int(11) NOT NULL,
	customer_id int(11) NOT NULL,
	sale_date date NOT NULL,
	PRIMARY KEY(sale_id),
	FOREIGN KEY fk_sale_book_id (book_id) REFERENCES book (book_id),
	FOREIGN KEY fk_sale_salesman_name (salesman_id) REFERENCES salesman (salesman_id),
	FOREIGN KEY fk_sale_customer_name (customer_id) REFERENCES customer (customer_id)
	) ENGINE=InnoDB";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));
	
	$csvfile = "csv/cities.csv";
	$city = array_map('str_getcsv', file($csvfile));
	$district = array_column($city, 1);
	$tmp = array();
	$tmp = array_values(array_unique($district));
	for ($x = 0; $x < 7; $x++) {
		$sql = "INSERT INTO district (district_name) VALUES ('$tmp[$x]')";
		$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));
	}
	$city = array_column($city, 0);
	for ($x = 0; $x < 81; $x++) {
		$sql = "INSERT INTO city (city_name, district_name) VALUES ('$city[$x]', '$district[$x]')";
		$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));
	}
	$csvfile = "csv/branch.csv";
	$branch = array_map('str_getcsv', file($csvfile));
	$branch = array_column($branch, 0);
	for ($x = 0; $x < 81; $x++) {
		shuffle($branch);
		for ($y = 0; $y < 5; $y++) {
			$sql = "INSERT INTO branch (branch_name, city_name) VALUES ('$branch[$y]', '$city[$x]')";
			$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));
		}
	}
	$csvfile = "csv/books.csv";
	$book = array_map('str_getcsv', file($csvfile));
	$book = array_column($book, 0);
	shuffle($book);
	for ($x = 0; $x < 200; $x++) {
		$rint = rand(1, 200) / 2;
		$sql = "INSERT INTO book (book_name, price) VALUES ('$book[$x]', '$rint')";
		$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));
	}
	$csvfile = "csv/names.csv";
	$name = array_map('str_getcsv', file($csvfile));
	$name = array_column($name, 0);
	$csvfile = "csv/lastnames.csv";
	$surname = array_map('str_getcsv', file($csvfile));
	$surname = array_column($surname, 0);
	// Random name and surname
	for ($x = 0; $x < 1215; $x++) {
		$y = ($x % 405) + 1;
		$random_name = $name[array_rand($name)];
		$random_surname = $surname[array_rand($surname)];
		$smanName = $random_name . " " . $random_surname;
		$sql = "INSERT INTO salesman (salesman_name, branch_id) VALUES ('$smanName', '$y')";
		$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));
	}
	for ($x = 0; $x < 1620; $x++) {
		$random_name = $name[array_rand($name)];
		$random_surname = $surname[array_rand($surname)];
		$cusName = $random_name . " " . $random_surname;
		$sql = "INSERT INTO customer (customer_name) VALUES ('$cusName')";
		$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));
		$rint = rand(0, 5);
		$z = $x + 1;
		for ($y = 0; $y < $rint; $y++) {
			$rint1 = rand(1, 200);
			$rint2 = rand(1, 1215);
			$timestamp = mt_rand(1, time());
			$randomDate = date("Y-m-d", $timestamp);
			$sql = "INSERT INTO sale (book_id, salesman_id, customer_id, sale_date) VALUES ('$rint1', '$rint2', '$z', '$randomDate')";
			$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));
		}
	}
	
	mysqli_close($conn);
}
if(array_key_exists('ins',$_POST)){
   inst();
}
?>

</body>
</html>