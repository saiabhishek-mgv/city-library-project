<?php
require 'db.php';
session_start();

// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php"); // Redirect if not logged in
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $publisherId = $_POST['publisher_id'];
    $pubName = $_POST['pub_name'];
    $address = $_POST['address'];

    try {
        $stmt = $pdo->prepare("INSERT INTO PUBLISHER (PUBLISHERID, PUBNAME, ADDRESS) VALUES (?, ?, ?)");
        if ($stmt->execute([$publisherId, $pubName, $address])) {
            echo "<p>Publisher added successfully!</p>";
        } else {
            echo "<p>Error adding publisher.</p>";
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
    <title>Add Publisher</title>
</head>
<body>
    <h1>Add New Publisher</h1>
    <form method="post">
        <input type="text" name="publisher_id" placeholder="Publisher ID" required>
        <input type="text" name="pub_name" placeholder="Publisher Name" required>
        <input type="text" name="address" placeholder="Publisher Address" required>
        <button type="submit">Add Publisher</button>
    </form>
    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
