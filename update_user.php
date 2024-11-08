<?php
$conn = new mysqli("localhost", "root", "", "stardust");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $sql = "UPDATE users SET name='$name', email='$email', contact='$contact', address='$address' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully";
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
$conn->close();
header("Location: users-list-page.php"); // Redirect back to user list
exit();

