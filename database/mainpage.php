<!DOCTYPE html>
<html>
<body>
<?php
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
    // button
	echo "<form action='ShowCitySalesInformation.php' method='post'>";
	echo '<input type="submit" value="Show City Sales Info">';
	echo "</form>";
	echo '<br/><br/>';
	// button
	echo "<form action='BranchSalesInformation.php' method='post'>";
	echo '<input type="submit" value="Branch Sales Info">';
	echo "</form>";
	echo '<br/><br/>';
	// button
	echo "<form action='Report.php' method='post'>";
	echo '<input type="submit" value="Report">';
	echo "</form>";
mysqli_close($conn);
?>

</body>
</html>