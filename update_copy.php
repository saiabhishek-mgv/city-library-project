<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    // Fetch current data to populate the form
    $docId = $_POST['doc_id'];
    $copyNo = $_POST['copy_no'];
    $branchId = $_POST['branch_id'];

    $stmt = $pdo->prepare("SELECT * FROM COPIES WHERE DOCID = ? AND COPYNO = ? AND BID = ?");
    $stmt->execute([$docId, $copyNo, $branchId]);
    $copy = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_update'])) {
    // Handle the form submission to update the database
    $newDocId = $_POST['doc_id'];
    $newCopyNo = $_POST['copy_no'];
    $newBranchId = $_POST['branch_id'];
    $newPosition = $_POST['position'];

    $stmt = $pdo->prepare("UPDATE COPIES SET DOCID = ?, COPYNO = ?, BID = ?, POSITION = ? WHERE DOCID = ? AND COPYNO = ? AND BID = ?");
    if ($stmt->execute([$newDocId, $newCopyNo, $newBranchId, $newPosition, $docId, $copyNo, $branchId])) {
        echo "<script>alert('Document copy successfully updated.'); window.location.href='admin_menu.php';</script>";
    } else {
        echo "<script>alert('Error updating document copy.'); window.location.href='admin_menu.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Document Copy</title>
</head>
<body>
    <h1>Update Document Copy</h1>
    <?php if (!empty($copy)): ?>
    <form method="post">
        <input type="hidden" name="doc_id" value="<?php echo htmlspecialchars($copy['DOCID']); ?>">
        <input type="text" name="copy_no" value="<?php echo htmlspecialchars($copy['COPYNO']); ?>" required>
        <input type="text" name="branch_id" value="<?php echo htmlspecialchars($copy['BID']); ?>" required>
        <input type="text" name="position" value="<?php echo htmlspecialchars($copy['POSITION']); ?>" required>
        <button type="submit" name="submit_update">Update Copy</button>
    </form>
    <?php endif; ?>
    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
