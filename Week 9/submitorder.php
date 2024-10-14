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

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_ids']) && isset($_POST['quantity']) && isset($_POST['current_price'])) {
        $product_ids = [];
        $orderDetails = [];
        $grandTotal = 0.0;

        foreach ($_POST['product_ids'] as $id) {
            $quantity = intval($_POST['quantity'][$id]); // Convert to integer to remove leading zeros
            $currentPrice = $_POST['current_price'][$id];
            if ($quantity > 0) {
                $subtotal = $quantity * $currentPrice;
                $grandTotal += $subtotal;
                $orderDetails[] = [
                    'id' => $id,
                    'quantity' => $quantity,
                    'price_per_cup' => $currentPrice,
                    'subtotal' => $subtotal
                ];
            }
        }
        

        if (!empty($orderDetails)) {
            $orderDetailsJson = json_encode($orderDetails);
            $stmt = $conn->prepare("INSERT INTO orders (order_date, order_details, grand_total) VALUES (NOW(), ?, ?)");
            $stmt->bind_param("sd", $orderDetailsJson, $grandTotal);
            if ($stmt->execute()) {
                $message = "Order submitted successfully.";
            } else {
                $message = "Failed to submit order.";
            }
            $stmt->close();
        } else {
            $message = "No products selected.";
        }
    } else {
        $message = "Please select products and provide quantities.";
    }
}

$conn->close();

// Redirect back to menu.php with a message
header("Location: menu.php?message=" . urlencode($message));
exit();
?>
