<?php
require 'db.php';
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

// // Ensure only logged-in admins can access this page
// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php");
//     exit();
// }

// Fetch document IDs and titles for the dropdown
$documents = $pdo->query("SELECT DOCID, TITLE FROM DOCUMENT")->fetchAll(PDO::FETCH_ASSOC);
// Fetch branch IDs and names for the dropdown
$branches = $pdo->query("SELECT BID, LNAME FROM BRANCH")->fetchAll(PDO::FETCH_ASSOC);

$results = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $docId = $_POST['doc_id'];
    $branchId = $_POST['branch_id'];

    // Query to calculate total copies, borrowed copies, available copies, and availability status
    $stmt = $pdo->prepare("
    SELECT COPIES.DOCID, COPIES.BID, COUNT(*) AS TotalCopies,
    SUM(CASE WHEN RDTIME IS NULL THEN 1 ELSE 0 END) AS CopiesBorrowed,
    SUM(CASE WHEN RDTIME IS NOT NULL THEN 1 ELSE 0 END) AS CopiesAvailable,
    MIN(RDTIME) AS EarliestAvailableDate
    FROM COPIES
    LEFT JOIN (
        SELECT A.DOCID, A.COPYNO, A.BID, B.RDTIME
        FROM BORROWS A
        JOIN BORROWING B ON A.BOR_NO = B.BOR_NO
    ) X ON COPIES.DOCID = X.DOCID AND COPIES.COPYNO = X.COPYNO AND COPIES.BID = X.BID
    WHERE COPIES.DOCID = ? AND COPIES.BID = ?
    GROUP BY COPIES.DOCID, COPIES.BID    
    ");
    $stmt->execute([$docId, $branchId]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Document Copy</title>
</head>
<body>
    <h1>Search Document Copy</h1>
    <form method="post">
        <label for="doc_id">Document ID:</label>
        <select name="doc_id" id="doc_id" required>
            <option value="">Select Document</option>
            <?php foreach ($documents as $document) {
                echo "<option value='{$document['DOCID']}'>{$document['DOCID']} - {$document['TITLE']}</option>";
            } ?>
        </select>
        <label for="branch_id">Branch ID:</label>
        <select name="branch_id" id="branch_id" required>
            <option value="">Select Branch</option>
            <?php foreach ($branches as $branch) {
                echo "<option value='{$branch['BID']}'>{$branch['BID']} - {$branch['LNAME']}</option>";
            } ?>
        </select>
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($results)): ?>
        <h2>Search Results</h2>
        <table border="1">
            <tr>
                <th>Document ID</th>
                <th>Branch ID</th>
                <th>Total Copies</th>
                <th>Copies Borrowed</th>
                <th>Copies Available</th>
                <th>Status</th>
                <th>Earliest Available Date</th>
            </tr>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['DOCID']); ?></td>
                    <td><?php echo htmlspecialchars($row['BID']); ?></td>
                    <td><?php echo htmlspecialchars($row['TotalCopies']); ?></td>
                    <td><?php echo htmlspecialchars($row['CopiesBorrowed']); ?></td>
                    <td><?php echo htmlspecialchars($row['CopiesAvailable']); ?></td>
                    <td><?php echo $row['CopiesAvailable'] > 0 ? 'Available' : 'Not Available'; ?></td>
                    <td><?php echo $row['CopiesAvailable'] > 0 ? 'N/A' : htmlspecialchars($row['EarliestAvailableDate']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No results found.</p>
    <?php endif; ?>

    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
