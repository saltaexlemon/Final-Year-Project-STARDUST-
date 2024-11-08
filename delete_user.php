<?php
$conn = new mysqli("localhost", "root", "", "stardust");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}
$conn->close();
header("Location: users-list-page.php"); // Redirect back to user list
exit();
?>