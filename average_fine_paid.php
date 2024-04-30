<?php
require 'db.php';
session_start();

// // Ensure only logged-in admins can access this page
// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php");
//     exit();
// }

$averageFines = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Query to calculate the average fine paid per branch for the specified period
    $stmt = $pdo->prepare("
        SELECT BR.BID, BR.LNAME, AVG(IFNULL(F.FineAmount, 0)) AS AverageFine
        FROM BRANCH BR
        LEFT JOIN BORROWS BO ON BR.BID = BO.BID
        LEFT JOIN (
            SELECT BOR_NO, SUM(Fine) AS FineAmount
            FROM BORROWING
            WHERE RDateTime BETWEEN ? AND ?
            GROUP BY BOR_NO
        ) F ON BO.BOR_NO = F.BOR_NO
        GROUP BY BR.BID, BR.LNAME
    ");
    $stmt->execute([$startDate, $endDate]);
    $averageFines = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Average Fine Per Branch</title>
</head>
<body>
    <h1>Average Fine Per Branch</h1>
    <form method="post">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
        
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>
        
        <button type="submit">Calculate Average Fine</button>
    </form>

    <?php if (!empty($averageFines)): ?>
        <h2>Average Fine Paid Per Branch</h2>
        <table border="1">
            <tr>
                <th>Branch ID</th>
                <th>Branch Name</th>
                <th>Average Fine ($)</th>
            </tr>
            <?php foreach ($averageFines as $fine): ?>
                <tr>
                    <td><?= htmlspecialchars($fine['BID']); ?></td>
                    <td><?= htmlspecialchars($fine['LNAME']); ?></td>
                    <td><?= number_format($fine['AverageFine'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No data found for the specified period.</p>
    <?php endif; ?>

    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
