<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "javajam";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check for a message in the query string
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JavaJam Coffee House Menu</title>
</head>
<body>
    <h1>JavaJam Coffee House Menu</h1>
    <form action="priceupdate.php" method="POST">
        <table border="1">
            <tr>
                <th>Select</th>
                <th>Product</th>
                <th>Current Price</th>
                <th>New Price</th>
                <th>Quantity</th> <!-- Add a quantity column -->
            </tr>
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root"; // Default XAMPP username
            $password = ""; // Default XAMPP password
            $dbname = "javajam";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch product data
            $sql = "SELECT id, name, price FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td><input type='checkbox' name='product_ids[]' value='" . $row["id"] . "'></td>
                            <td>" . $row["name"] . "</td>
                            <td>$" . number_format($row["price"], 2) . "</td>
                            <td><input type='text' name='new_price[" . $row["id"] . "]' placeholder='Enter new price'></td>
                            <td><input type='number' name='quantity[" . $row["id"] . "]' min='1' value='1'></td> <!-- Quantity input -->
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No products available</td></tr>";
            }
            $conn->close();
            ?>
        </table>
        <button type="submit" name="action" value="update_prices">Update Prices</button>
        <button type="submit" name="action" value="submit_order">Submit Order</button>
        <button type="submit" name="action" value="generate_report">Generate Report</button>
    </form>
</body>
</html>