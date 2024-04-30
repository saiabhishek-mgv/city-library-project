<?php
require 'db.php';
session_start();

// Ensure only logged-in readers can access this page
if (!isset($_SESSION['reader_id'])) {
    header("Location: login.php");  // Redirect to login page
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = ""; // To display messages to the user

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $documentId = $_POST['document_id'];
    $copyNo = $_POST['copy_no'];
    $readerId = $_SESSION['reader_id']; // Assuming reader's ID is stored in session when they log in

    // Check if the document copy is available
    $checkStmt = $pdo->prepare("SELECT * FROM COPIES WHERE DOCID = ? AND COPYNO = ? AND Available = 'Yes'");
    $checkStmt->execute([$documentId, $copyNo]);
    $copy = $checkStmt->fetch();

    if ($copy) {
        // Perform the checkout operation
        try {
            $pdo->beginTransaction();

            // Update the copy status to 'No' indicating it is not available
            $updateStmt = $pdo->prepare("UPDATE COPIES SET Available = 'No' WHERE DOCID = ? AND COPYNO = ?");
            $updateStmt->execute([$documentId, $copyNo]);

            // Calculate return date (7 days from now)
            $returnDate = new DateTime('+7 days');

            // Record the borrowing in the BORROWS table, including the expected return date
            $borrowStmt = $pdo->prepare("INSERT INTO BORROWS (RID, DOCID, COPYNO, BID, BDateTime, RDateTime) VALUES (?, ?, ?, ?, NOW(), ?)");
            $borrowStmt->execute([$readerId, $documentId, $copyNo, $copy['BID'], $returnDate->format('Y-m-d H:i:s')]);

            $pdo->commit();
            $message = "Document checked out successfully!";
        } catch (Exception $e) {
            $pdo->rollBack();
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "This document copy is not available for checkout.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document Checkout</title>
</head>
<body>
    <h1>Document Checkout</h1>
    <form method="post">
        <label for="document_id">Document ID:</label>
        <input type="text" id="document_id" name="document_id" required>
        
        <label for="copy_no">Copy Number:</label>
        <input type="text" id="copy_no" name="copy_no" required>
        
        <button type="submit">Checkout Document</button>
    </form>

    <?php if (!empty($message)): ?>
        <p><?= $message; ?></p>
    <?php endif; ?>

    <p><a href="reader_menu.php">Back to Reader Menu</a></p>
</body>
</html>
