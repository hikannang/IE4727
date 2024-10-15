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

// Initialize arrays to store sales data
$salesData = [
    "Single Shots" => 0,
    "Double Shots" => 0,
    "Unlimited" => 0
];

// Initialize date filter variable
$dateFilter = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';

// Build SQL query with date filter
$sql = "SELECT order_details FROM orders";
if ($dateFilter) {
    $sql .= " WHERE DATE(order_date) = '$dateFilter'";
}

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orderDetails = json_decode($row["order_details"], true);
        foreach ($orderDetails as $detail) {
            $product_id = $detail['id'];
            $quantity = (int)$detail['quantity'];

            // Combine product IDs into categories
            if ($product_id == 2 || $product_id == 4) {
                $salesData["Single Shots"] += $quantity;
            } elseif ($product_id == 3 || $product_id == 5) {
                $salesData["Double Shots"] += $quantity;
            } elseif ($product_id == 1) {
                $salesData["Unlimited"] += $quantity;
            }
        }
    }
}

// Sort categories by total quantity sold in descending order
arsort($salesData);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales by Category - JavaJam Coffee House</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Sales by Category</h1>
    </header>
    <main>
        <section>
        <form method="get" action="">
            <label for="filter_date">Filter by Date:</label>
            <input type="date" id="filter_date" name="filter_date" value="<?php echo $dateFilter; ?>">
            <input type="submit" value="Filter">
        </form>
            <table>
                <tr>
                    <th>Category</th>
                    <th>Total Quantity Sold</th>
                </tr>
                <?php foreach ($salesData as $categoryName => $totalQuantity): ?>
                    <tr>
                        <td><?php echo $categoryName; ?></td>
                        <td><?php echo $totalQuantity; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
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
