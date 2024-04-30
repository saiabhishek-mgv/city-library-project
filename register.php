<?php
// Include the common database connection file
include 'db.php';

// Handle form submission for user registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registerUser"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $role = "User"; // Set a default role for registered users

    // Check if the username already exists
    $checkUsernameQuery = "SELECT * FROM Users WHERE Username = ?";
    $checkStmt = $conn->prepare($checkUsernameQuery);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
    } elseif ($password !== $confirmPassword) {
        echo "Password and Confirm Password do not match.";
    } else {
        // Perform the necessary database operations to register a new user
        $insertQuery = "INSERT INTO Users (Username, Password, Role) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("sss", $username, $password, $role);
        $insertStmt->execute();
        $insertStmt->close();

        echo "Registration successful. You can now log in.";
    }

    $checkStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
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
            text-align: center;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    

    <!-- User Registration form -->
    <form method="post" action="">
    <h2>User Registration</h2>
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" required><br>

        <button type="submit" name="registerUser">Register</button>
        <p>Already have an account? <a href="login.php">Log in here</a>.</p>
    </form>

    

    <ul>
        <!-- Add more navigation links if needed -->
    </ul>
</body>
</html>