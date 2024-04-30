<?php
session_start();

// Redirect to login if the reader is not logged in
if (!isset($_SESSION['reader_id'])) {
    header("Location: login.php");
    exit();
}

// Display a personalized greeting
$readerName = $_SESSION['reader_name'] ?? 'Reader';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Menu</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($readerName); ?></h1>
    <h2>Main Menu</h2>
    <ul>
        <li><a href="search_document.php">Search Document</a></li>
        <li><a href="checkout_document.php">Checkout Document</a></li>
        <li><a href="return_document.php">Return Document</a></li>
        <li><a href="view_transactions.php">View My Transactions</a></li>
    </ul>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
