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

$message = "";

// Process POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_ids']) && isset($_POST['new_price'])) {
        $success = false; // Flag to check if any price was updated successfully
        foreach ($_POST['product_ids'] as $product_id) {
            $new_price = $_POST['new_price'][$product_id];
            if (is_numeric($new_price) && $new_price > 0) {
                $stmt = $conn->prepare("UPDATE products SET price = ? WHERE id = ?");
                $stmt->bind_param("di", $new_price, $product_id);

                if ($stmt->execute()) {
                    $success = true; // Set flag to true if at least one update is successful
                } else {
                    $message .= "Error updating price for Product ID: $product_id. ";
                }

                $stmt->close();
            } else {
                $message .= "Invalid price entered for Product ID: $product_id. ";
            }
        }
        if ($success) {
            $message .= "Price updated successfully.";
        }
    } else {
        $message = "Product IDs and new prices are required.";
    }
}

$conn->close();

// Redirect back to menu with a message
header("Location: menu.php?message=" . urlencode($message));
exit();
?>