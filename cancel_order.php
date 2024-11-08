<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    echo "Order ID received: " . htmlspecialchars($order_id) . "<br>"; // Debug line

    // Database connection
    $host = 'localhost';
    $dbname = 'stardust';
    $user = 'root';
    $password = '';

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the order exists and is awaiting
    $sql = "SELECT status FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();

    echo "Order status: " . htmlspecialchars($status) . "<br>"; // Debug line

    if ($status == 'Awaiting') {
        // Delete the order if status is 'Awaiting'
        $sql = "DELETE FROM orders WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        if ($stmt->execute()) {
            echo "Order has been successfully deleted.";
        } else {
            echo "Failed to delete the order.";
        }
        $stmt->close();
    } else {
        echo "Order cannot be deleted as it is not in 'Awaiting' status.";
    }

    $conn->close();

    // Redirect back to the account page
    header("Location: account.php");
    exit();
} else {
    echo "Invalid request. Method: " . htmlspecialchars($_SERVER['REQUEST_METHOD']) . "<br>"; // Debug line
    echo "Order ID: " . (isset($_POST['order_id']) ? htmlspecialchars($_POST['order_id']) : "Not set") . "<br>"; // Debug line
}
