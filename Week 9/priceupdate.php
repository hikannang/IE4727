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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'update_prices':
            if (isset($_POST['product_ids']) && isset($_POST['new_price'])) {
                foreach ($_POST['product_ids'] as $id) {
                    $newPrice = $_POST['new_price'][$id];
                    if (is_numeric($newPrice) && $newPrice > 0) {
                        $sql = "UPDATE products SET price = ? WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("di", $newPrice, $id);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
                $message = "Prices updated successfully.";
            } else {
                $message = "No products selected or invalid price.";
            }
            break;

        case 'submit_order':
            // Implement order submission logic here
            $message = "Order submitted successfully.";
            break;

        case 'generate_report':
            // Implement report generation logic here
            $message = "Report generated successfully.";
            break;

        default:
            $message = "Invalid action.";
            break;
    }
}

$conn->close();

// Redirect back to menu.php with a message
header("Location: menu.php?message=" . urlencode($message));
exit();
