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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_ids']) && isset($_POST['quantity'])) {
        $orderSuccess = true;

        foreach ($_POST['product_ids'] as $id) {
            $quantity = $_POST['quantity'][$id];

            // Fetch product price
            $sql = "SELECT price FROM products WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($price);
            $stmt->fetch();
            $stmt->close();

            if ($quantity > 0) {
                $totalPrice = $price * $quantity;
                $sql = "INSERT INTO orders (product_id, quantity, total_price, order_date) VALUES (?, ?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iid", $id, $quantity, $totalPrice);
                if (!$stmt->execute()) {
                    $orderSuccess = false;
                }
                $stmt->close();
            }
        }

        $message = $orderSuccess ? "Order submitted successfully." : "Failed to submit order.";
    } else {
        $message = "Please select products and provide quantities.";
    }
}

$conn->close();

// Redirect back to menu.php with a message
header("Location: menu.php?message=" . urlencode($message));
exit();
