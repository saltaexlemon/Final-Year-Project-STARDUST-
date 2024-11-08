<?php
$conn = new mysqli("localhost", "root", "", "stardust");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $typeoftoy = $_POST['typeoftoy'];
    $totalQty = $_POST['totalQty'];
    $shipsFrom = $_POST['shipsFrom'];

    $sql = "UPDATE items SET title='$title', rating='$rating', price='$price', category='$category', typeoftoy='$typeoftoy', totalQty='$totalQty', shipsFrom='$shipsFrom' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Item updated successfully";
    } else {
        echo "Error updating item: " . $conn->error;
    }
}
$conn->close();
header("Location: inventory-page.php"); // Redirect back to inventory list
exit();
?>