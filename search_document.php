<?php
require 'db.php';
session_start();

// // Ensure only logged-in readers can access this page
// if (!isset($_SESSION['reader'])) {
//     header("Location: login.php");  // Redirect to login page
//     exit();
// }

$searchResults = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $documentId = $_POST['document_id'] ?? ''; // Using null coalescing operator to handle non-existent input
    $title = $_POST['title'] ?? '';
    $publisherName = $_POST['publisher_name'] ?? '';

    // Construct the SQL query dynamically based on input provided
    $conditions = [];
    $params = [];
    if (!empty($documentId)) {
        $conditions[] = 'DOCID = ?';
        $params[] = $documentId;
    }
    if (!empty($title)) {
        $conditions[] = 'TITLE LIKE ?';
        $params[] = "%$title%";
    }
    if (!empty($publisherName)) {
        $conditions[] = 'PUBLISHERID IN (SELECT PUBLISHERID FROM PUBLISHER WHERE PUBNAME LIKE ?)';
        $params[] = "%$publisherName%";
    }

    if (!empty($conditions)) {
        $stmt = $pdo->prepare("
            SELECT DOCID, TITLE, PDATE, PUBNAME AS PUBLISHER_NAME
            FROM DOCUMENT INNER JOIN PUBLISHER ON DOCUMENT.PUBLISHERID = PUBLISHER.PUBLISHERID
            WHERE " . implode(' AND ', $conditions)
        );
        $stmt->execute($params);
        $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Document</title>
</head>
<body>
    <h1>Search a Document</h1>
    <form method="post">
        <label for="document_id">Document ID:</label>
        <input type="text" id="document_id" name="document_id">

        <label for="title">Title:</label>
        <input type="text" id="title" name="title">

        <label for="publisher_name">Publisher Name:</label>
        <input type="text" id="publisher_name" name="publisher_name">

        <button type="submit">Search</button>
    </form>

    <?php if (!empty($searchResults)): ?>
        <h2>Search Results</h2>
        <table border="1">
            <tr>
                <th>Document ID</th>
                <th>Title</th>
                <th>Publication Date</th>
                <th>Publisher Name</th>
            </tr>
            <?php foreach ($searchResults as $document): ?>
                <tr>
                    <td><?= htmlspecialchars($document['DOCID']); ?></td>
                    <td><?= htmlspecialchars($document['TITLE']); ?></td>
                    <td><?= htmlspecialchars($document['PDATE']); ?></td>
                    <td><?= htmlspecialchars($document['PUBNAME']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($searchResults)): ?>
        <p>No documents found matching your search criteria.</p>
    <?php endif; ?>

    <p><a href="reader_menu.php">Back to Reader Menu</a></p>
</body>
</html>
