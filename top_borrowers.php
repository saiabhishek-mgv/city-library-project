<?php
require 'db.php';
session_start();

// // Ensure only logged-in admins can access this page
// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php");
//     exit();
// }

$branches = $pdo->query("SELECT BID, LNAME FROM BRANCH")->fetchAll(PDO::FETCH_ASSOC);
$topBorrowers = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $branchId = $_POST['branch_id'];
    $numberN = $_POST['number_n'];

    // Fetch the top N borrowers for the given branch
    $stmt = $pdo->prepare("
        SELECT R.RID, R.RNAME, COUNT(*) AS BooksBorrowed
        FROM READER R
        JOIN BORROWS B ON R.RID = B.RID
        WHERE B.BID = ?
        GROUP BY R.RID, R.RNAME
        ORDER BY COUNT(*) DESC
        LIMIT ?
    ");
    $stmt->execute([$branchId, $numberN]);
    $topBorrowers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top Borrowers</title>
</head>
<body>
    <h1>Top Borrowers</h1>
    <form method="post">
        <label for="branch_id">Select Branch:</label>
        <select name="branch_id" id="branch_id" required>
            <option value="">Select a Branch</option>
            <?php foreach ($branches as $branch): ?>
                <option value="<?= htmlspecialchars($branch['BID']); ?>"><?= htmlspecialchars($branch['BID']) . " - " . htmlspecialchars($branch['LNAME']); ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="number_n">Number of Top Borrowers:</label>
        <input type="number" id="number_n" name="number_n" required min="1">
        
        <button type="submit">Get Top Borrowers</button>
    </form>

    <?php if (!empty($topBorrowers)): ?>
        <h2>Top Borrowers in Branch</h2>
        <table border="1">
            <tr>
                <th>Borrower ID</th>
                <th>Name</th>
                <th>Books Borrowed</th>
            </tr>
            <?php foreach ($topBorrowers as $borrower): ?>
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
