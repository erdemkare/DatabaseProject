<!DOCTYPE html>
<html>
<body>
<?php
echo '<br/>';
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "erdem_erdem";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
} 
//all sales divided into districts
$sql = "SELECT district_name, COUNT(sale_id) AS SaleCount FROM ((sale INNER JOIN salesman USING (salesman_id) INNER JOIN branch USING (branch_id)) INNER JOIN city USING (city_name)) group by district_name";
$result = mysqli_query($conn,$sql) or die("Error");
if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td>District Name</td><td>Sale Count</td></tr>";
	while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
		echo "<td>" . $row["district_name"]. "</td><td>" . $row["SaleCount"]. "</td>";
		echo "</tr>";
	}
	echo "</table>";
} else {
    echo "0 results";
}
echo "</br>";
//all sales divided into branchs
$sql = "SELECT branch_name, COUNT(sale_id) AS SaleCount FROM (sale INNER JOIN salesman USING (salesman_id) INNER JOIN branch USING (branch_id)) group by branch_name";
$result = mysqli_query($conn,$sql) or die("Error");
if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td>Branch Name</td><td>Sale Count</td></tr>";
	while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
		echo "<td>" . $row["branch_name"]. "</td><td>" . $row["SaleCount"]. "</td>";
		echo "</tr>";
	}
	echo "</table>";
} else {
    echo "0 results";
}
mysqli_close($conn);
?>
</body>
</html>