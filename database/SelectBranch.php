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
// button
echo "<form method='post'>";
echo '<input type="submit" name="prod" id="prod" value="book">';
echo "</form>";
echo '<br/>';

// button
echo "<form method='post'>";
echo '<input type="submit" name="sman" id="sman" value="Salesman">';
echo "</form>";
echo '<br/>';

// button
$sql = "SELECT salesman_name FROM salesman";
$result = mysqli_query($conn,$sql) or die("Error");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<form method='post'>";
	echo '<select name="thesman">';
    while($row = mysqli_fetch_array($result)) {
		echo "<option value='" . $row["salesman_name"] . "'>";
        echo $row["salesman_name"];
		echo "</option>";
    }
	echo '</select>';
	echo '<input type="submit" name="chsman" id="chsman" value="Choose Salesman">';
	echo "</form>";
} else {
    echo "0 results";
}
echo '<br/>';

// button
$sql = "SELECT customer_name FROM customer";
$result = mysqli_query($conn,$sql) or die("Error");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<form method='post'>";
	echo '<select name="thecus">';
    while($row = mysqli_fetch_array($result)) {
		echo "<option value='" . $row["customer_name"] . "'>";
        echo $row["customer_name"];
		echo "</option>";
    }
	echo '</select>';
	echo '<input type="submit" name="chcus" id="chcus" value="Choose Customer">';
	echo "</form>";
} else {
    echo "0 results";
}
mysqli_close($conn);
echo '<br/><br/>';

function prod()
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
	$sql = "SELECT book_name, COUNT(sale_id) AS SaleCount FROM sale INNER JOIN book USING (book_id) group by book_id";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		echo "<table border='1'>";
		echo "<tr><td>book Name</td><td>Sale Count</td></tr>";
		while($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo "<td>" . $row["book_name"]. "</td><td>" . $row["SaleCount"]. "</td>";
			echo "</tr>";
		}
		echo "</table>";
	} else {
		echo "0 results";
	}
	mysqli_close($conn);
}
function sman()
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
	$sql = "SELECT salesman_name, COUNT(sale_id) AS SaleCount FROM sale INNER JOIN salesman USING (salesman_id) group by salesman_id";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		echo "<table border='1'>";
		echo "<tr><td>Salesman Name</td><td>Sale Count</td></tr>";
		while($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo "<td>" . $row["salesman_name"]. "</td><td>" . $row["SaleCount"]. "</td>";
			echo "</tr>";
		}
		echo "</table>";
	} else {
		echo "0 results";
	}
	mysqli_close($conn);
}
function chsman()
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
	$sql = "SELECT book_name, customer_name, price, sale_date FROM (sale INNER JOIN salesman USING (salesman_id) INNER JOIN book USING (book_id) INNER JOIN customer USING (customer_id)) WHERE salesman_name = '" . $_POST['thesman'] . "'";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		echo "books Sold by " . $_POST['thesman'] . '<br/><br/>';
		echo "<table border='1'>";
		echo "<tr><td>book Name</td><td>Customer Name</td><td>Price</td><td>Sale Date</td></tr>";
		while($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo "<td>" . $row["book_name"]. "</td><td>" . $row["customer_name"]. "</td><td>" . $row["price"]. "</td><td>" . $row["sale_date"]. "</td>";
			echo "</tr>";
		}
		echo "</table>";
	} else {
		echo "0 results";
	}
	mysqli_close($conn);
}
function chcus()
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
	$sql = "SELECT book_name, price, sale_date FROM (sale INNER JOIN book USING (book_id) INNER JOIN customer USING (customer_id)) WHERE customer_name = '" . $_POST['thecus'] . "'";
	$result = mysqli_query($conn,$sql) or die( mysqli_error($conn));

	$total = 0;
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		echo "books Bought by " . $_POST['thecus'] . '<br/><br/>';
		echo "<table border='1'>";
		echo "<tr><td>book Name</td><td>Price</td><td>Sale Date</td></tr>";
		while($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo "<td>" . $row["book_name"]. "</td><td>" . $row["price"]. "</td><td>" . $row["sale_date"]. "</td>";
			$total += $row["price"];
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td>Total Invoice: </td><td>" . $total . "</td>";
		echo "</tr>";
		echo "</table>";
	} else {
		echo "0 results";
	}
	mysqli_close($conn);
}
if(array_key_exists('prod',$_POST)){
   prod();
}
if(array_key_exists('sman',$_POST)){
   sman();
}
if(array_key_exists('chsman',$_POST)){
   chsman();
}
if(array_key_exists('chcus',$_POST)){
   chcus();
}
?>
</body>
</html>