<?php
require 'db.php';
session_start();

// // Ensure only logged-in admins can access this page
// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php");
//     exit();
// }

$topGlobalBorrowers = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numberN = $_POST['number_n'];

    // Query to fetch the top N borrowers in the entire library
    $stmt = $pdo->prepare("
        SELECT R.RID, R.RNAME, COUNT(*) AS BooksBorrowed
        FROM READER R
        JOIN BORROWS B ON R.RID = B.RID
        GROUP BY R.RID, R.RNAME
        ORDER BY COUNT(*) DESC
        LIMIT ?
    ");
    $stmt->execute([$numberN]);
    $topGlobalBorrowers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top Global Borrowers</title>
</head>
<body>
    <h1>Top Global Borrowers</h1>
    <form method="post">
        <label for="number_n">Number of Top Borrowers:</label>
        <input type="number" id="number_n" name="number_n" required min="1">
        
        <button type="submit">Get Top Borrowers</button>
    </form>

    <?php if (!empty($topGlobalBorrowers)): ?>
        <h2>Top Borrowers in the Library</h2>
        <table border="1">
            <tr>
                <th>Borrower ID</th>
                <th>Name</th>
                <th>Books Borrowed</th>
            </tr>
            <?php foreach ($topGlobalBorrowers as $borrower): ?>
                <tr>
                    <td><?= htmlspecialchars($borrower['RID']); ?></td>
                    <td><?= htmlspecialchars($borrower['RNAME']); ?></td>
                    <td><?= htmlspecialchars($borrower['BooksBorrowed']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No results found or invalid input.</p>
    <?php endif; ?>

    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
