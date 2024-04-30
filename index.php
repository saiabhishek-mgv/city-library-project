<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include the common database connection file
include 'db_connection.php';

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>the City Library System</title>
</head>
<body>
    <h1>Library Management System</h1>

    <!-- Logout form -->
    <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>

    <ul>
        
    </ul>
</body>
</html>