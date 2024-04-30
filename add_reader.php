<?php
require 'db.php';
session_start();

// // Ensure only logged-in admins can access this page
// if (!isset($_SESSION['admin'])) {
//     header("Location: menu.php");
//     exit();
// }

$message = "";  // To display messages to the user

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rtype = $_POST['rtype'];
    $rname = $_POST['rname'];
    $raddress = $_POST['raddress'];
    $phone_no = $_POST['phone_no'];

    // Input validation or sanitization can be added here
    try {
        $stmt = $pdo->prepare("INSERT INTO READER (RTYPE, RNAME, RADDRESS, PHONE_NO) VALUES (?, ?, ?, ?)");
        $stmt->execute([$rtype, $rname, $raddress, $phone_no]);
        $message = "Reader added successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Reader</title>
</head>
<body>
    <h1>Add New Reader</h1>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="rtype">Type:</label>
        <select id="rtype" name="rtype" required>
            <option value="">Select Type</option>
            <option value="Student">Student</option>
            <option value="Senior Citizen">Senior Citizen</option>
            <option value="Staff">Staff</option>
            <option value="Others">Others</option>
        </select>

        <label for="rname">Name:</label>
        <input type="text" id="rname" name="rname" required>

        <label for="raddress">Address:</label>
        <input type="text" id="raddress" name="raddress" required>

        <label for="phone_no">Phone Number:</label>
        <input type="text" id="phone_no" name="phone_no" required>

        <button type="submit">Add Reader</button>
    </form>

    <p><a href="admin_menu.php">Back to Admin Menu</a></p>
</body>
</html>
