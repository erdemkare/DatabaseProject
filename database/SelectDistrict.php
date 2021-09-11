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
$sql = "SELECT city_name FROM city";
$result = mysqli_query($conn,$sql) or die("Error");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<form method='post'>";
	echo '<select name="thecity">';
    while($row = mysqli_fetch_array($result)) {
		echo "<option value='" . $row["city_name"] . "'>";
        echo $row["city_name"];
		echo "</option>";
    }
	echo '</select>';
	echo '<input type="submit" name="show" id="show" value="Show">';
	echo "</form>";
} else {
    echo "0 results";
}
mysqli_close($conn);
function show()
{
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
	echo '<br/>';
	$sql = "SELECT branch_name, COUNT(sale_id) AS SaleCount FROM (sale INNER JOIN salesman USING (salesman_id) INNER JOIN branch USING (branch_id)) WHERE city_name = '" . $_POST['thecity'] . "' " . "group by branch_id";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

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
}
if(array_key_exists('show',$_POST)){
   show();
}
?>

</body>
</html>