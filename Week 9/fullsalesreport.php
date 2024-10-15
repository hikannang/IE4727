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
$productResult = $conn->query("SELECT id, name FROM products");

if ($productResult->num_rows > 0) {
    while ($productRow = $productResult->fetch_assoc()) {
        $productNames[$productRow['id']] = $productRow['name'];
    }
}

// Initialize variables for date filter
$filterDate = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
$allTime = isset($_GET['all_time']);

// Build SQL query with optional date filtering
$sql = "SELECT order_id, order_date, order_details, grand_total FROM orders";
if ($filterDate && !$allTime) {
    $sql .= " WHERE DATE(order_date) = '$filterDate'";
}
$sql .= " ORDER BY order_date DESC";

$result = $conn->query($sql);

// Calculate earnings
$totalEarnings = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Sales Report - JavaJam Coffee House</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Full Sales Report</h1>
    </header>
    <main>
        <section>
            <form method="get" action="">
                <label for="filter_date">Filter by Date:</label>
                <input type="date" id="filter_date" name="filter_date" value="<?php echo $filterDate; ?>">
                <label for="all_time">
                    <input type="checkbox" id="all_time" name="all_time" <?php if ($allTime) echo 'checked'; ?>> All Time
                </label>
                <input type="submit" value="Filter">
            </form>
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Products</th>
                        <th>Price Per Cup</th>
                        <th>Quantities</th>
                        <th>Subtotals</th>
                        <th>Grand Total</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php $totalEarnings += $row["grand_total"]; ?>
                        <tr>
                            <td><?php echo $row["order_id"]; ?></td>
                            <td><?php echo $row["order_date"]; ?></td>
                            <td>
                                <?php
                                $orderDetails = json_decode($row["order_details"], true);
                                $productsList = [];
                                foreach ($orderDetails as $detail) {
                                    $product_name = isset($productNames[$detail['id']]) ? $productNames[$detail['id']] : "Unknown Product";
                                    $productsList[] = $product_name;
                                }
                                echo implode("<br>", $productsList);
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach ($orderDetails as $detail) {
                                    echo "$" . number_format($detail['price_per_cup'], 2) . "<br>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach ($orderDetails as $detail) {
                                    echo $detail['quantity'] . " Cups<br>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach ($orderDetails as $detail) {
                                    echo "$" . number_format($detail['subtotal'], 2) . "<br>";
                                }
                                ?>
                            </td>
                            <td><?php echo "$" . number_format($row["grand_total"], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <p style="text-align: center; font-weight: bold; color: #8b4513;">
                    Total Earnings: $<?php echo number_format($totalEarnings, 2); ?>
                </p>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>
            <div class="button-group">
                <button onclick="window.location.href='salesreport.php'">Back</button>
            </div>
        </section>
    </main>
    <footer>
    <small><i>Copyright &copy; 2014 JavaJam Coffee House<br>
    hongwei@leong.com</i></small>
</footer>
</body>
</html>

<?php
$conn->close();
?>
