<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $docId = $_POST['doc_id'];
    $copyNo = $_POST['copy_no'];
    $branchId = $_POST['branch_id'];

    // Prepare and execute the delete statement
    $stmt = $pdo->prepare("DELETE FROM COPIES WHERE DOCID = ? AND COPYNO = ? AND BID = ?");
    if ($stmt->execute([$docId, $copyNo, $branchId])) {
        echo "<script>alert('Document copy successfully deleted.'); window.location.href='admin_menu.php';</script>";
    } else {
        echo "<script>alert('Error deleting document copy.'); window.location.href='admin_menu.php';</script>";
    }
}
?>
