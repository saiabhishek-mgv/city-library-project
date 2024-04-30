<?php
session_start();
require '../db.php';  // Assumes the database connection is set up in this file

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Redirect to login if the reader is not logged in
if (!isset($_SESSION['reader_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$availableCopies = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check_availability'])) {
    $documentId = $_POST['document_id'];

    // Check total available copies for the entered document ID
    try {
        $checkStmt = $pdo->prepare("SELECT COUNT(*) AS AvailableCopies FROM COPIES LEFT JOIN BORROWS ON COPIES.DOCID = BORROWS.DOCID AND COPIES.COPYNO = BORROWS.COPYNO AND BORROWS.RDateTime >= NOW() WHERE COPIES.DOCID = ? AND BORROWS.BOR_NO IS NULL");
        $checkStmt->execute([$documentId]);
        $result = $checkStmt->fetch();
        $availableCopies = $result['AvailableCopies'];
        $message = "Available copies: " . $availableCopies;
    } catch (Exception $e) {
        $message = "Error checking availability: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $documentId = $_POST['document_id'];
    $copyNo = $_POST['copy_no'];
    $readerId = $_SESSION['reader_id']; // Assuming reader's ID is stored in session

    try {
        // Check if the specific document copy is available
        $checkStmt = $pdo->prepare("SELECT * FROM COPIES LEFT JOIN BORROWS ON COPIES.DOCID = BORROWS.DOCID AND COPIES.COPYNO = BORROWS.COPYNO AND BORROWS.RDateTime >= NOW() WHERE COPIES.DOCID = ? AND COPIES.COPYNO = ? AND BORROWS.BOR_NO IS NULL");
        $checkStmt->execute([$documentId, $copyNo]);
        $copy = $checkStmt->fetch();

        if ($copy) {
            $pdo->beginTransaction();

            // Update the copy status to 'No' indicating it is not available
            // Assume this status update is done within the BORROWS table during the checkout process
            $returnDate = new DateTime('+7 days');

            // Record the borrowing in the BORROWS table
            $borrowStmt = $pdo->prepare("INSERT INTO BORROWS (RID, DOCID, COPYNO, BID, BDateTime, RDateTime) VALUES (?, ?, ?, ?, NOW(), ?)");
            $borrowStmt->execute([$readerId, $documentId, $copyNo, $copy['BID'], $returnDate->format('Y-m-d H:i:s')]);

            $pdo->commit();
            $message = "Document checked out successfully!";
        } else {
            $message = "This document copy is not available for checkout.";
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Checkout failed: " . $e->getMessage();
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
        
        <button type="submit" name="check_availability">Check Availability</button>
        <br><br>
        <label for="copy_no">Copy Number:</label>
        <input type="text" id="copy_no" name="copy_no">
        
        <button type="submit" name="checkout">Checkout Document</button>
    </form>

    <?php if (!empty($message)): ?>
        <p><?= $message; ?></p>
    <?php endif; ?>

    <p><a href="main_menu.php">Back to Main Menu</a></p>
</body>
</html>
