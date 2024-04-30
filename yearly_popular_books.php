<?php
require 'db.php';
session_start();

// // Ensure only logged-in admins can access this page
// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php");
//     exit();
// }

$popularBooks = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $year = $_POST['year'];

    // Query to fetch the top 10 most borrowed books in the specified year
    $stmt = $pdo->prepare("
        SELECT D.DOCID, D.TITLE, COUNT(B.BOR_NO) AS BorrowCount
        FROM DOCUMENT D
        JOIN BORROWS B ON D.DOCID = B.DOCID
        JOIN BORROWING BR ON B.BOR_NO = BR.BOR_NO
        WHERE YEAR(BR.BDTIME) = ?
        GROUP BY D.DOCID, D.TITLE
        ORDER BY BorrowCount DESC
        LIMIT 10
    ");
    $stmt->execute([$year]);
    $popularBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yearly Most Popular Books</title>
</head>
<body>
    <h1>Most Popular Books of the Year</h1>
    <form method="post">
        <label for="year">Enter Year:</label>
        <input type="number" id="year" name="year" required>
        
        <button type="submit">Get Books</button>
    </form>

    <?php if (!empty($popularBooks)): ?>
        <h2>Top 10 Most Borrowed Books in <?= htmlspecialchars($_POST['year']); ?></h2>
        <table border="1">
            <tr>
                <th>Document ID</th>
                <th>Title</th>
                <th>Borrow Count</th>
            </tr>
            <?php foreach ($popularBooks as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['DOCID']); ?></td>
                    <td><?= htmlspecialchars($book['TITLE']); ?></td>
                    <td><?= htmlspecialchars($book['BorrowCount']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No results found for <?= htmlspecialchars($_POST['year']); ?>.</p>
    <?php endif; ?>

    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
