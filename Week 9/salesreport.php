<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report - JavaJam Coffee House</title>
    <link rel="stylesheet" href="style.css"> <!-- Assuming styles.css is used for styling -->
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
            <div class="button-group">
                <button onclick="window.location.href='menu.php'">Back</button>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 JavaJam Coffee House</p>
    </footer>
</body>
</html>
