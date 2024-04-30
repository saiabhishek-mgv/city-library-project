<?php
session_start();

// Check if the user is already logged in, redirect if true
if (isset($_SESSION['username'])) {
    // Redirect admin to dashboard.php
    if ($_SESSION['role'] === 'Admin') {
        header("Location: dashboard.php");
        exit();
    } elseif ($_SESSION['role'] === 'Manager') {
        // Redirect manager to asset_management.php
        header("Location: asset_management.php");
        exit();
    } else {
        // Redirect other users to their respective pages
        header("Location: index.php");
        exit();
    }
}

// Include the common database connection file
include 'db.php';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM Users WHERE Username = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['Role'];

        // Redirect admin to dashboard.php
        if ($_SESSION['role'] === 'Admin') {
            header("Location: dashboard.php");
            exit();
        } elseif ($_SESSION['role'] === 'Manager') {
            // Redirect manager to asset_management.php
            header("Location: asset_management.php");
            exit();
        } else {
            // Redirect other users to their respective pages
            header("Location: index.php");
            exit();
        }
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-image: url('background.jpg'); /* Set your background image */
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: rgba(255, 255, 255, 0.7); /* Adjust the alpha value for transparency */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Optional: Add a box shadow */
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Login form -->
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
        <p>Don't have an account? <a href="register.php">Sign Up here</a>.</p>
    </form>
    
</body>
</html>