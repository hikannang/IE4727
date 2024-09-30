<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h1>Form Data</h1>";
    echo "<p><strong>Name:</strong> " . htmlspecialchars($_POST['name']) . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($_POST['email']) . "</p>";
    echo "<p><strong>Start Date:</strong> " . htmlspecialchars($_POST['startdate']) . "</p>";
    echo "<p><strong>Experience:</strong> " . htmlspecialchars($_POST['experience']) . "</p>";
}
?>