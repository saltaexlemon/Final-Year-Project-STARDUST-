<?php
$conn = new mysqli("localhost", "root", "", "stardust");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $typeoftoy = $_POST['typeoftoy'];
    $totalQty = $_POST['totalQty'];
    $shipsFrom = $_POST['shipsFrom'];

    $targetDir = "assets/";
    $imgPath = null;
    $imgPathPrev1 = null;
    $imgPathPrev2 = null;

    // Handle main image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileType = $_FILES['image']['type'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($fileType, $allowedTypes)) {
            die("Invalid file type. Only JPEG, PNG, and GIF types are allowed.");
        }

        $fileName = basename($_FILES['image']['name']);
        $uniqueFileName = uniqid() . "_" . $fileName;
        $imgPath = $uniqueFileName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $uniqueFileName)) {
            die("Failed to upload image.");
        }
    } else {
        die("Image upload error: " . $_FILES['image']['error']);
    }

    // Handle Preview Image 1
    if (isset($_FILES['img_prev1']) && $_FILES['img_prev1']['error'] == 0) {
        $fileType = $_FILES['img_prev1']['type'];

        if (!in_array($fileType, $allowedTypes)) {
            die("Invalid file type. Only JPEG, PNG, and GIF types are allowed.");
        }

        $fileName = basename($_FILES['img_prev1']['name']);
        $uniqueFileName = uniqid() . "_prev1_" . $fileName;
        $imgPathPrev1 = $uniqueFileName;

        if (!move_uploaded_file($_FILES['img_prev1']['tmp_name'], $targetDir . $uniqueFileName)) {
            die("Failed to upload preview image 1.");
        }
    }

    // Handle Preview Image 2
    if (isset($_FILES['img_prev2']) && $_FILES['img_prev2']['error'] == 0) {
        $fileType = $_FILES['img_prev2']['type'];

        if (!in_array($fileType, $allowedTypes)) {
            die("Invalid file type. Only JPEG, PNG, and GIF types are allowed.");
        }

        $fileName = basename($_FILES['img_prev2']['name']);
        $uniqueFileName = uniqid() . "_prev2_" . $fileName;
        $imgPathPrev2 = $uniqueFileName;

        if (!move_uploaded_file($_FILES['img_prev2']['tmp_name'], $targetDir . $uniqueFileName)) {
            die("Failed to upload preview image 2.");
        }
    }

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO items (title, rating, price, category, typeoftoy, totalQty, shipsFrom, img, img_prev1, img_prev2) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssssisss", $title, $rating, $price, $category, $typeoftoy, $totalQty, $shipsFrom, $imgPath, $imgPathPrev1, $imgPathPrev2);

    if ($stmt->execute()) {
        echo "New product added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: inventory-page.php");
    exit();
}
