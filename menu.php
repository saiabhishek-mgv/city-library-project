<?php
require 'db.php';

function handlePostRequest() {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'search_document':
                searchDocument();
                break;
            case 'checkout_document':
                checkoutDocument();
                break;
            // Add cases for other actions here
        }
    }
}

function searchDocument() {
    global $pdo;
    $searchTerm = $_POST['search_term'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM DOCUMENT WHERE DOCID = :term OR TITLE LIKE :title OR PUBLISHERID IN (SELECT PUBLISHERID FROM PUBLISHER WHERE PUBNAME LIKE :pubname)");
    $stmt->execute(['term' => $searchTerm, 'title' => "%$searchTerm%", 'pubname' => "%$searchTerm%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Search Results:</h2>";
    if ($results) {
        echo "<ul>";
        foreach ($results as $row) {
            echo "<li>Document ID: {$row['DOCID']}, Title: {$row['TITLE']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No documents found.</p>";
    }
}

function checkoutDocument() {
    // Implement checkout logic and display result
}

handlePostRequest();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library System</title>
</head>
<body>
    <h1>Library Management System</h1>
    <form method="post">
        <input type="hidden" name="action" value="search_document">
        <label for="search_term">Search Documents:</label>
        <input type="text" id="search_term" name="search_term" required>
        <button type="submit">Search</button>
    </form>

    <!-- Other forms for different functionalities -->
    <form method="post">
        <input type="hidden" name="action" value="checkout_document">
        <label for="doc_id">Document ID for Checkout:</label>
        <input type="text" id="doc_id" name="doc_id" required>
        <button type="submit">Checkout</button>
    </form>

    <!-- You can add more forms and functionalities as needed -->
</body>
</html>
