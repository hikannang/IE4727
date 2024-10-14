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
    <title>JavaJam Coffee House - Menu</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>JavaJam Coffee House</h1>
    </header>
    <main>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="music.html">Music</a></li>
                <li><a href="jobs.html">Jobs</a></li>
            </ul>
        </nav>
        <section>
            <h2>Coffee at JavaJam</h2>
            <?php if ($message) : ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="priceupdate.php" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Product</th>
                            <th>Current Price</th>
                            <th>New Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch product data
                        $sql = "SELECT id, name, price FROM products";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td><input type='checkbox' name='product_ids[]' value='" . $row["id"] . "'></td>
                                        <td>" . htmlspecialchars($row["name"]) . "</td>
                                        <td>$" . number_format($row["price"], 2) . "</td>
                                        <td><input type='text' name='new_price[" . $row["id"] . "]' placeholder='Enter new price'></td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No products available</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
                <div class="button-group">
                    <button type="submit" name="action" value="update_prices">Update Prices</button>
                    <button type="submit" name="action" value="submit_order">Submit Order</button>
                    <button type="submit" name="action" value="generate_report">Generate Report</button>
                </div>
            </form>
        </section>
    </main>
    <footer>
        <small>&copy; 2014 JavaJam Coffee House<br>
        <a href="mailto:hongwei@leong.com">hongwei@leong.com</a></small>
    </footer>
</body>
</html>
