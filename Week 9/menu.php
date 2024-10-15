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
    <title>JavaJam Coffee House</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function toggleFields(checkbox, id) {
            var newPriceField = document.getElementById('new_price_' + id);
            var quantityField = document.getElementById('quantity_' + id);
            newPriceField.disabled = !checkbox.checked;
            quantityField.disabled = !checkbox.checked;
        }

        function calculateSubtotal(id, price) {
            const quantity = parseInt(document.getElementById('quantity_' + id).value) || 0;
            const subtotal = price * quantity;
            document.getElementById('subtotal_' + id).innerText = '$' + subtotal.toFixed(2);
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('[id^="subtotal_"]').forEach(element => {
                grandTotal += parseFloat(element.innerText.replace('$', '')) || 0;
            });
            document.getElementById('grandTotal').innerText = '$' + grandTotal.toFixed(2);
        }
    </script>
</head>

<body>
    <header>
        JavaJam Coffee House
    </header>
    <main>
        <nav>
            <a href="index.html">Home</a>
            <a href="menu.html">Menu</a>
            <a href="music.html">Music</a>
            <a href="jobs.html">Jobs</a>
        </nav>
        <section>
            <h2>Coffee at JavaJam</h2>

            <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>

            <form id="menuForm" method="POST">
                <table border="1">
                    <tr>
                        <th>Select</th>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Current Price</th>
                        <th>New Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php
                // Fetch product data including descriptions
                $sql = "SELECT id, name, description, price FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td><input type='checkbox' name='product_ids[]' value='" . $row["id"] . "' onchange='toggleFields(this, " . $row["id"] . ")'></td>
                                <td>" . $row["name"] . "</td>
                                <td>" . $row["description"] . "</td>
                                <td>$" . number_format($row["price"], 2) . "</td>
                                <input type='hidden' name='current_price[" . $row["id"] . "]' value='" . $row["price"] . "'>
                                <td><input type='text' id='new_price_" . $row["id"] . "' name='new_price[" . $row["id"] . "]' placeholder='Enter new price' disabled></td>
                                <td><input type='number' id='quantity_" . $row["id"] . "' name='quantity[" . $row["id"] . "]' min='0' value='0' disabled oninput='calculateSubtotal(" . $row["id"] . ", " . $row["price"] . ")'></td>
                                <td><span id='subtotal_" . $row["id"] . "'>$0.00</span></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No products available</td></tr>";
                }
                $conn->close();
                ?>
                    <tr>
                        <td colspan="6" align="right" style="font-weight:bold; text-align: right;">Grand Total:</td>
                        <td><span id="grandTotal">$0.00</span></td>
                    </tr>
                </table>
                <div class="button-group">
                    <button type="submit" formaction="priceupdate.php">Update Prices</button>
                    <button type="submit" formaction="submitorder.php">Submit Order</button>
                    <button type="submit" formaction="salesreport.php">Generate Report</button>
                </div>
            </form>
        </section>
    </main>
    <footer>
        <small><i>Copyright &copy; 2014 JavaJam Coffee House<br>
                hongwei@leong.com</i></small>
    </footer>
</body>

</html>