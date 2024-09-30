<?php
// Start a session to store messages if needed
session_start();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $startdate = htmlspecialchars(trim($_POST['startdate']));
    $experience = htmlspecialchars(trim($_POST['experience']));

    // Basic validation (in addition to client-side validation)
    $errors = [];

    if (!preg_match("/^[A-Za-z\s]+$/", $name)) {
        $errors[] = "Name must contain alphabet characters and spaces only.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    $today = date("Y-m-d");
    if (!empty($startdate) && $startdate <= $today) {
        $errors[] = "Start date must be in the future.";
    }

    if (empty($experience)) {
        $errors[] = "Experience is required.";
    }

    // Display errors if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        // Display the submitted data
        echo "<h2>Job Application Submitted</h2>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Start Date:</strong> $startdate</p>";
        echo "<p><strong>Experience:</strong> $experience</p>";
    }
} else {
    echo "<p>No data was submitted.</p>";
}
?>
