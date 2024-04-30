<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin, otherwise deny access
if ($_SESSION['role'] !== 'Admin') {
    echo "Access denied. Only admins can access this page.";
    exit();
}

// Include the common database connection file
include 'db.php';

// Handle form submission for creating a new user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createUser"])) {
    $newUsername = $_POST["newUsername"];
    $newPassword = $_POST["newPassword"];
    $newRole = $_POST["role"];

    // Perform the necessary database operations to create a new user
    $sql = "INSERT INTO Users (Username, Password, Role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $newUsername, $newPassword, $newRole);
    $stmt->execute();
    $stmt->close();

    echo "User created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(144, 238, 144, 0.3); /* Light green with reduced opacity */
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        a:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
    <h2>Create User</h2>

    <!-- Create User form -->
    <form method="post" action="">
        <label for="newUsername">New Username:</label>
        <input type="text" name="newUsername" required><br>

        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" required><br>

        <label for="role">Select Role:</label>
        <select name="role" id="role">
            <option value="Admin">Admin</option>
            <option value="User">User</option>
            <option value="Manager">Manager</option>
            <!-- Add more options if needed -->
        </select>

        <button type="submit" name="createUser">Create User</button>
    </form>

    <ul>
        <li><a href="view_users.php">Back to View Users</a></li>
        <li><a href="dashboard.php">Back to Dashboard</a></li>
    </ul>
</body>
</html>