<?php
require 'db.php';
session_start();

// // Ensure only logged-in admins can access this page
// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php");
//     exit();
// }

$mostBorrowedBooks = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numberN = $_POST['number_n'];

    // Query to fetch the N most borrowed books in the entire library
    $stmt = $pdo->prepare("
        SELECT D.DOCID, D.TITLE, COUNT(B.BOR_NO) AS BorrowCount
        FROM DOCUMENT D
        JOIN BORROWS B ON D.DOCID = B.DOCID
        GROUP BY D.DOCID, D.TITLE
        ORDER BY BorrowCount DESC
        LIMIT ?
    ");
    $stmt->execute([$numberN]);
    $mostBorrowedBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Most Borrowed Books in the Library</title>
</head>
<body>
    <h1>Most Borrowed Books in the Library</h1>
    <form method="post">
        <label for="number_n">Number of Most Borrowed Books:</label>
        <input type="number" id="number_n" name="number_n" required min="1">
        
        <button type="submit">Get Books</button>
    </form>

    <?php if (!empty($mostBorrowedBooks)): ?>
        <h2>Top Borrowed Books in the Library</h2>
        <table border="1">
            <tr>
                <th>Document ID</th>
                <th>Title</th>
                <th>Borrow Count</th>
            </tr>
            <?php foreach ($mostBorrowedBooks as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['DOCID']); ?></td>
                    <td><?= htmlspecialchars($book['TITLE']); ?></td>
                    <td><?= htmlspecialchars($book['BorrowCount']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No results found or invalid input.</p>
    <?php endif; ?>

    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
