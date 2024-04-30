<?php
require 'db.php';
session_start();

// // Ensure only logged-in admins can access this page
// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php");
//     exit();
// }

$branches = $pdo->query("SELECT BID, LNAME, LOCATION FROM BRANCH")->fetchAll(PDO::FETCH_ASSOC);

$selectedBranchInfo = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $branchId = $_POST['branch_id'];

    // Fetch the branch information based on selected BID
    $stmt = $pdo->prepare("SELECT LNAME, LOCATION FROM BRANCH WHERE BID = ?");
    $stmt->execute([$branchId]);
    $selectedBranchInfo = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Branch Information</title>
</head>
<body>
    <h1>Print Branch Information</h1>
    <form method="post">
        <label for="branch_id">Select Branch:</label>
        <select name="branch_id" id="branch_id" required>
            <option value="">Select a Branch</option>
            <?php foreach ($branches as $branch): ?>
                <option value="<?= htmlspecialchars($branch['BID']); ?>"><?= htmlspecialchars($branch['BID']) . " - " . htmlspecialchars($branch['LNAME']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Show Information</button>
    </form>

    <?php if ($selectedBranchInfo): ?>
        <h2>Branch Details</h2>
        <p><strong>Name:</strong> <?= htmlspecialchars($selectedBranchInfo['LNAME']); ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($selectedBranchInfo['LOCATION']); ?></p>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No branch information found.</p>
    <?php endif; ?>

    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
