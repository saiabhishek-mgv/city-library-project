<?php
require 'db.php';
session_start();

// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php");
//     exit();
// }

$publishers = $pdo->query("SELECT PUBLISHERID, PUBNAME FROM PUBLISHER")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $docId = $_POST['doc_id'];
    $title = $_POST['title'];
    $publisherId = $_POST['publisher_id'];
    $publicationDate = $_POST['publication_date'];

    try {
        $stmt = $pdo->prepare("INSERT INTO DOCUMENT (DOCID, TITLE, PUBLISHERID, PDATE) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$docId, $title, $publisherId, $publicationDate])) {
            echo "<p>Document added successfully!</p>";
        } else {
            echo "<p>Error adding document.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Document</title>
</head>
<body>
    <h1>Add New Document</h1>
    <form method="post">
        <input type="text" name="doc_id" placeholder="Document ID" required>
        <input type="text" name="title" placeholder="Title" required>
        <select name="publisher_id" required>
            <option value="">Select Publisher</option>
            <?php foreach ($publishers as $publisher) {
                echo "<option value='{$publisher['PUBLISHERID']}'>{$publisher['PUBNAME']}</option>";
            } ?>
        </select>
        <input type="date" name="publication_date" placeholder="Publication Date" required>
        <button type="submit">Add Document</button>
    </form>
    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
