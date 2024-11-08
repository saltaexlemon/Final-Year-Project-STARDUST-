<?php
$conn = new mysqli("localhost", "root", "", "stardust");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the item ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch image paths for the item
    $sql = "SELECT img, img_prev1, img_prev2 FROM items WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($img, $img_prev1, $img_prev2);
    $stmt->fetch();
    $stmt->close();

    // Delete images from assets folder if they exist
    if ($img && file_exists("assets/$img")) {
        unlink("assets/$img");
    }
    if ($img_prev1 && file_exists("assets/$img_prev1")) {
        unlink("assets/$img_prev1");
    }
    if ($img_prev2 && file_exists("assets/$img_prev2")) {
        unlink("assets/$img_prev2");
    }

    // Delete the item from the database
    $sql = "DELETE FROM items WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Item deleted successfully";
    } else {
        echo "Error deleting item: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No item ID provided.";
}

$conn->close();

// Redirect back to inventory list
header("Location: inventory-page.php");
exit();
