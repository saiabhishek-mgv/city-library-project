<?php
require 'db.php';  // Ensure your database connection file is correctly referenced

session_start(); // Start a new session or resume the existing one

// Handle post request to process actions
function handlePostRequest() {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'reader_login':
                readerLogin();
                break;
            case 'admin_login':
                adminLogin();
                break;
        }
    }
}

// Function to validate reader login
function readerLogin() {
    global $pdo;
    $cardNumber = $_POST['card_number'] ?? '';
    // Assume a reader table with card number exists
    $stmt = $pdo->prepare("SELECT * FROM READER WHERE RID = ?");
    $stmt->execute([$cardNumber]);
    $reader = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reader) {
        $_SESSION['reader'] = $reader;  // Store reader info in session
        header("Location: reader_menu.php"); // Redirect to a reader-specific menu page
        exit();
    } else {
        echo "<p>Invalid Card Number. Please try again.</p>";
    }
}

// Function to validate admin login
function adminLogin() {
    global $pdo;
    $adminId = $_POST['admin_id'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE UserID = ? AND Password = ?");
    $stmt->execute([$adminId, $password]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $_SESSION['admin'] = $admin;  // Store admin info in session
        header("Location: admin_menu.php"); // Redirect to an admin-specific menu page
        exit();
    } else {
        echo "<p>Invalid ID or Password. Please try again.</p>";
    }
}

handlePostRequest();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library System Main Menu</title>
</head>
<body>
    <h1>Welcome to the Library Management System</h1>
    <h2>Main Menu</h2>
    <form method="post">
        <input type="hidden" name="action" value="reader_login">
        <label for="card_number">Enter Reader Card Number:</label>
        <input type="text" id="card_number" name="card_number" required>
        <button type="submit">Reader Login</button>
    </form>

    <form method="post">
        <input type="hidden" name="action" value="admin_login">
        <label for="admin_id">Admin ID:</label>
        <input type="text" id="admin_id" name="admin_id" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Admin Login</button>
    </form>
</body>
</html>
