<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "javajam";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product data to map product IDs to product names
$productNames = [];
$productPrices = []; // To store total price and count for average calculation
$productResult = $conn->query("SELECT id, name FROM products");

if ($productResult->num_rows > 0) {
    while ($productRow = $productResult->fetch_assoc()) {
        $productNames[$productRow['id']] = $productRow['name'];
        $productPrices[$productRow['id']] = ['totalPrice' => 0, 'count' => 0];
    }
}

// Initialize arrays to store sales data
$totalQuantities = [];
$subtotalSales = [];

// Fetch orders
$sql = "SELECT order_details FROM orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orderDetails = json_decode($row["order_details"], true);
        foreach ($orderDetails as $detail) {
            $product_id = $detail['id'];
            $quantity = (int)$detail['quantity'];
            $price_per_cup = (float)$detail['price_per_cup']; // Assuming price_per_cup is stored in order_details

            // Calculate total quantities and subtotal sales
            if (!isset($totalQuantities[$product_id])) {
                $totalQuantities[$product_id] = 0;
                $subtotalSales[$product_id] = 0.0;
            }
            $totalQuantities[$product_id] += $quantity;
            $subtotalSales[$product_id] += $quantity * $price_per_cup;

            // Update product price for average calculation
            $productPrices[$product_id]['totalPrice'] += $price_per_cup * $quantity;
            $productPrices[$product_id]['count'] += $quantity;
        }
    }
}

// Determine the most sold product
$mostSoldProduct = null;
$maxQuantity = 0;
foreach ($totalQuantities as $id => $quantity) {
    if ($quantity > $maxQuantity) {
        $maxQuantity = $quantity;
        $mostSoldProduct = $productNames[$id]; // Get the name instead of the ID
}
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report - JavaJam Coffee House</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Sales Reports</h1>
    </header>
    <main>
        <section>
            <h2>Generate Reports</h2>
            <ul>
                <li><a href="salesbyproduct.php">Sales by Product</a></li>
                <li><a href="salesbycategories.php">Sales by Categories</a></li>
                <li><a href="fullsalesreport.php">Full Sales Report</a></li>
            </ul>
            <!-- New table for total quantities, average price, and total sales -->
            <table>
                <tr>
                    <th>Type of Coffee</th>
                    <th>Total Quantity Sold</th>
                    <th>Average Price (SGD)</th>
                    <th>Total Sales (SGD)</th>
                </tr>
                <?php foreach ($totalQuantities as $id => $quantity): ?>
                <tr>
                    <td><?php echo $productNames[$id]; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td>
                        <?php
                            $averagePrice = $productPrices[$id]['count'] > 0 ? $productPrices[$id]['totalPrice'] / $productPrices[$id]['count'] : 0;
                            echo number_format($averagePrice, 2);
                            ?>
                    </td>
                    <td><?php echo number_format($subtotalSales[$id], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <p style="text-align: center; font-weight: bold; color: #8b4513;">
                Most Sold Product: <?php echo $mostSoldProduct; ?> with <?php echo $maxQuantity; ?> units sold.
            </p>
            <div class="button-group">
                <button onclick="window.location.href='menu.php'">Back</button>
            </div>
        </section>
    </main>
    <footer>
        <small><i>Copyright &copy; 2014 JavaJam Coffee House<br>
                hongwei@leong.com</i></small>
    </footer>
</body>

</html>