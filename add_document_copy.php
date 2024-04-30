<?php
require 'db.php';
session_start();

// Uncomment this to ensure only logged-in admins can access this page
// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php");
//     exit();
// }

// Fetch BID and LNAME for branches dropdown
$branches = $pdo->query("SELECT BID, LNAME FROM BRANCH")->fetchAll(PDO::FETCH_ASSOC);
// Fetch DOCID and TITLE for documents dropdown
$documents = $pdo->query("SELECT DOCID, TITLE FROM DOCUMENT")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $docId = $_POST['doc_id'];
    $copyNo = $_POST['copy_no'];
    $branchId = $_POST['branch_id'];
    $position = $_POST['position'];

    try {
        $stmt = $pdo->prepare("INSERT INTO COPIES (DOCID, COPYNO, BID, POSITION) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$docId, $copyNo, $branchId, $position])) {
            echo "<p>Document copy added successfully!</p>";
        } else {
            echo "<p>Error adding document copy.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}

// Fetch all entries from COPIES table to display
$copies = $pdo->query("SELECT * FROM COPIES")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Document Copy</title>
</head>
<body>
    <h1>Add Document Copy</h1>
    <form method="post">
        <label for="doc_id">Document ID:</label>
        <select name="doc_id" id="doc_id" required>
            <option value="">Select Document</option>
            <?php foreach ($documents as $document) {
                echo "<option value='{$document['DOCID']}'>{$document['DOCID']} - {$document['TITLE']}</option>";
            } ?>
        </select>
        <label for="copy_no">Copy Number:</label>
        <input type="text" name="copy_no" id="copy_no" placeholder="Copy Number" required>
        <label for="branch_id">Branch:</label>
        <select name="branch_id" id="branch_id" required>
            <option value="">Select Branch</option>
            <?php foreach ($branches as $branch) {
                echo "<option value='{$branch['BID']}'>{$branch['BID']} - {$branch['LNAME']}</option>";
            } ?>
        </select>
        <label for="position">Position:</label>
        <input type="text" name="position" id="position" placeholder="Position" required>
        <button type="submit">Add Copy</button>
    </form>

    <h2>Current Copies in the Library</h2>
    <table border="1">
        <tr>
            <th>Document ID</th>
            <th>Copy Number</th>
            <th>Branch ID</th>
            <th>Position</th>
        </tr>
        <?php
        foreach ($copies as $copy) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($copy['DOCID']) . "</td>";
            echo "<td>" . htmlspecialchars($copy['COPYNO']) . "</td>";
            echo "<td>" . htmlspecialchars($copy['BID']) . "</td>";
            echo "<td>" . htmlspecialchars($copy['POSITION']) . "</td>";
            echo "<td>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='doc_id' value='{$copy['DOCID']}'>";
            echo "<input type='hidden' name='copy_no' value='{$copy['COPYNO']}'>";
            echo "<input type='hidden' name='branch_id' value='{$copy['BID']}'>";
            echo "<button name='delete' type='submit'>Delete</button>";
            echo "<button name='update' type='submit' formaction='update_copy.php'>Update</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
