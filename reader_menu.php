<?php
session_start();

// // Ensure only logged-in readers can access this page
// if (!isset($_SESSION['reader'])) {
//     header("Location: login.php");  // Redirect to login page
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reader Menu</title>
</head>
<body>
    <h1>Reader Functions Menu</h1>
    <ul>
        <li><a href="search_document.php">Search a Document by ID, Title, or Publisher Name</a></li>
        <li><a href="document_checkout.php">Document Checkout</a></li>
        <li><a href="document_return.php">Document Return</a></li>
        <li><a href="document_reserve.php">Document Reserve</a></li>
        <li><a href="compute_fine.php">Compute Fine for a Document Copy</a></li>
        <li><a href="list_reserved_documents.php">Print the List of Documents Reserved by a Reader</a></li>
        <li><a href="documents_by_publisher.php">Print the Document ID and Titles of Documents Published by a Publisher</a></li>
        <li><a href="logout.php">Quit</a></li>
    </ul>
</body>
</html>
