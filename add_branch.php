<?php
require 'db.php';
session_start();

// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php"); // Redirect if not logged in
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $branchId = $_POST['branch_id']; // Add branch ID input handling
    $branchName = $_POST['branch_name'];
    $location = $_POST['location'];

    // Prepare the SQL statement with error handling
    try {
        $stmt = $pdo->prepare("INSERT INTO BRANCH (BID, LNAME, LOCATION) VALUES (?, ?, ?)");
        if ($stmt->execute([$branchId, $branchName, $location])) {
            echo "<p>Branch added successfully!</p>";
        } else {
            echo "<p>Error adding branch.</p>";
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
    <title>Add Branch</title>
</head>
<body>
    <h1>Add New Branch</h1>
    <form method="post">
        <input type="text" name="branch_id" placeholder="Branch ID" required>
        <input type="text" name="branch_name" placeholder="Branch Name" required>
        <input type="text" name="location" placeholder="Location" required>
        <button type="submit">Add Branch</button>
    </form>
    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
