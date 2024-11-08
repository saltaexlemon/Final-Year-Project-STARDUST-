<?php
$host = 'localhost';
$dbname = 'stardust';
$user = 'root';
$password = '';

// Database connection
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $typeoftoy = $_POST['typeoftoy'];
    $totalQty = $_POST['totalQty'];
    $shipsFrom = $_POST['shipsFrom'];

    // Directory to store uploaded images
    $targetDir = "assets/";

    // Variables to hold image paths; default to null
    $imgPath = null;
    $imgPathPrev1 = null;
    $imgPathPrev2 = null;

    // Retrieve existing image paths from database
    $sql = "SELECT img, img_prev1, img_prev2 FROM items WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($existingImgPath, $existingImgPathPrev1, $existingImgPathPrev2);
    $stmt->fetch();
    $stmt->close();

    // Handle main image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['image']['type'];

        if (in_array($fileType, $allowedTypes)) {
            $fileName = basename($_FILES['image']['name']);
            $uniqueFileName = uniqid() . "_" . $fileName;
            $imgPath = $targetDir . $uniqueFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $imgPath)) {
                $imgPath = $uniqueFileName;
            } else {
                die("Failed to upload image.");
            }
        } else {
            die("Invalid file type. Only JPEG, PNG, and GIF types are allowed.");
        }
    } else {
        $imgPath = $existingImgPath;  // Keep existing image if no new upload
    }

    // Handle first preview image upload
    if (isset($_FILES['img_prev1']) && $_FILES['img_prev1']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['img_prev1']['type'];

        if (in_array($fileType, $allowedTypes)) {
            $fileName = basename($_FILES['img_prev1']['name']);
            $uniqueFileName = uniqid() . "_" . $fileName;
            $imgPathPrev1 = $targetDir . $uniqueFileName;

            if (move_uploaded_file($_FILES['img_prev1']['tmp_name'], $imgPathPrev1)) {
                $imgPathPrev1 = $uniqueFileName;
            } else {
                die("Failed to upload image.");
            }
        } else {
            die("Invalid file type. Only JPEG, PNG, and GIF types are allowed.");
        }
    } else {
        $imgPathPrev1 = $existingImgPathPrev1;  // Keep existing image if no new upload
    }

    // Handle second preview image upload
    if (isset($_FILES['img_prev2']) && $_FILES['img_prev2']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['img_prev2']['type'];

        if (in_array($fileType, $allowedTypes)) {
            $fileName = basename($_FILES['img_prev2']['name']);
            $uniqueFileName = uniqid() . "_" . $fileName;
            $imgPathPrev2 = $targetDir . $uniqueFileName;

            if (move_uploaded_file($_FILES['img_prev2']['tmp_name'], $imgPathPrev2)) {
                $imgPathPrev2 = $uniqueFileName;
            } else {
                die("Failed to upload image.");
            }
        } else {
            die("Invalid file type. Only JPEG, PNG, and GIF types are allowed.");
        }
    } else {
        $imgPathPrev2 = $existingImgPathPrev2;  // Keep existing image if no new upload
    }

    // Update item details including the image paths if set
    $sql = "UPDATE items SET title=?, rating=?, price=?, category=?, typeoftoy=?, totalQty=?, shipsFrom=?, img=?, img_prev1=?, img_prev2=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssssisssi", $title, $rating, $price, $category, $typeoftoy, $totalQty, $shipsFrom, $imgPath, $imgPathPrev1, $imgPathPrev2, $id);

    // Execute and check for success
    if ($stmt->execute()) {
        echo "Product updated successfully.";
    } else {
        echo "Error updating product: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: inventory-page.php");
    exit();
}
