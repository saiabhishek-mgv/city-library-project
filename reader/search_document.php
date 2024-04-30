<?php
session_start();
require '../db.php'; // Assumes the database connection is set up in this file

// Redirect to login if the reader is not logged in
if (!isset($_SESSION['reader_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$results = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $searchType = $_POST['search_type'];
    $searchQuery = trim($_POST['search_query']);

    if (!empty($searchQuery)) {
        if ($searchType === 'id') {
            $stmt = $pdo->prepare("SELECT * FROM DOCUMENT WHERE DOCID = ?");
        } elseif ($searchType === 'title') {
            $stmt = $pdo->prepare("SELECT * FROM DOCUMENT WHERE TITLE LIKE ?");
            $searchQuery = "%$searchQuery%";
        } elseif ($searchType === 'publisher') {
            $stmt = $pdo->prepare("SELECT DOCUMENT.* FROM DOCUMENT JOIN PUBLISHER ON DOCUMENT.PUBLISHERID = PUBLISHER.PUBLISHERID WHERE PUBLISHER.PUBNAME LIKE ?");
            $searchQuery = "%$searchQuery%";
        }

        $stmt->execute([$searchQuery]);
        $results = $stmt->fetchAll();
    } else {
        $message = "Please enter a search query.";
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
    <h1>Search Document</h1>
    <form method="post">
        <div>
            <label for="search_type">Search By:</label>
            <select id="search_type" name="search_type" required>
                <option value="id">Document ID</option>
                <option value="title">Title</option>
                <option value="publisher">Publisher Name</option>
            </select>
        </div>
        <div>
            <label for="search_query">Search Query:</label>
            <input type="text" id="search_query" name="search_query" required>
        </div>
        <button type="submit">Search</button>
    </form>

    <?php if ($message): ?>
        <p><?= $message; ?></p>
    <?php endif; ?>

    <?php if (!empty($results)): ?>
        <h2>Results</h2>
        <ul>
            <?php foreach ($results as $doc): ?>
                <li><?= htmlspecialchars($doc['TITLE']) ?> (ID: <?= $doc['DOCID'] ?>, Published Date: <?= $doc['PDATE'] ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p><a href="main_menu.php">Back to Main Menu</a></p>
</body>
</html>
