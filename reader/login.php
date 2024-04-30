<?php
session_start();
require '../db.php';  // Assumes the database connection is set up in this file

// Check if the user is already logged in
if (isset($_SESSION['reader_id'])) {
    header("Location: main_menu.php"); // Redirect to main menu if already logged in
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $readerId = $_POST['reader_id'];

    // Validate the reader ID
    $stmt = $pdo->prepare("SELECT RID, RNAME FROM READER WHERE RID = ?");
    $stmt->execute([$readerId]);
    $reader = $stmt->fetch();

    if ($reader) {
        $_SESSION['reader_id'] = $reader['RID'];
        $_SESSION['reader_name'] = $reader['RNAME'];  // Store reader name for personalized greeting
        header("Location: main_menu.php");
        exit();
    } else {
        $message = "Invalid reader ID. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reader Login</title>
</head>
<body>
    <h1>Reader Login</h1>
    <form method="post">
        <label for="reader_id">Reader ID:</label>
        <input type="text" id="reader_id" name="reader_id" required>
        <button type="submit">Login</button>
    </form>

    <?php if (!empty($message)): ?>
        <p><?= $message; ?></p>
    <?php endif; ?>
</body>
</html>
