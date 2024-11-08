<?php
include("navigation.php");

// Check if user is logged in
if (!isset($_COOKIE['user_email'])) {
    header("Location: login-page.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'stardust';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);
$user_email = $_COOKIE['user_email'];

// Fetch current user data
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Update user data if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $sql = "UPDATE users SET name = ?, contact = ?, address = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $contact, $address, $user_email);
    if ($stmt->execute()) {
        echo "<p class='success-edit'>Account details updated successfully.</p>";
    } else {
        echo "<p>Error updating account details: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Account Details</title>
    <link rel="stylesheet" href="./styles/account.css">
    <link rel="stylesheet" href="./styles/edit-acc.css">
</head>

<body>
    <div class="edit-account-container">
        <h2>Edit Account Details</h2>
        <form class='edit-form' method="post" action="edit_account.php">
            <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <input type="tel" name="contact" placeholder="Contact" value="<?php echo htmlspecialchars($user['contact']); ?>" required>
            <textarea name="address" placeholder="Shipping Address" required><?php echo htmlspecialchars($user['address']); ?></textarea>
            <button type="submit">Save Changes</button>
        </form>
        <a href="account.php"><button class="back-btn">Back to Account</button></a>
    </div>

</body>

</html>