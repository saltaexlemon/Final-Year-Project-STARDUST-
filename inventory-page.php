<?php
include("admin-sidebar.php");

// Database connection
$host = 'localhost';
$dbname = 'stardust';
$user = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM items";
$result = $conn->query($sql);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $typeoftoy = $_POST['typeoftoy'];
    $totalQty = $_POST['totalQty'];
    $shipsFrom = $_POST['shipsFrom'];

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $imageData = null;
    }

    // Determine if it's an update or new insertion
    if (!empty($id)) {
        // Update existing item
        $sql2 = "UPDATE items SET title=?, rating=?, price=?, category=?, typeoftoy=?, totalQty=?, shipsFrom=?";
        if ($imageData !== null) {
            $sql2 .= ", img=?";
        }
        $sql2 .= " WHERE id=?";

        $stmt = $conn->prepare($sql2);
        if ($imageData !== null) {
            $stmt->bind_param("ssssssssi", $title, $rating, $price, $category, $typeoftoy, $totalQty, $shipsFrom, $imageData, $id);
        } else {
            $stmt->bind_param("sssssssi", $title, $rating, $price, $category, $typeoftoy, $totalQty, $shipsFrom, $id);
        }
    } else {
        // Insert new item
        $sql2 = "INSERT INTO items (title, rating, price, category, typeoftoy, totalQty, shipsFrom, img) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("ssssssis", $title, $rating, $price, $category, $typeoftoy, $totalQty, $shipsFrom, $imageData);
    }

    if ($stmt->execute()) {

        $sql = "SELECT id, img, title, rating, price, category, typeoftoy, totalQty, shipsFrom FROM items";
        $result = $conn->query($sql);
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<link rel="stylesheet" href="./styles/admin-inventory.css">

<body>
    <div class="content">
        <h3 style="text-align:end;">Welcome back, Admin</h3>
        <p>Inventory</p>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Type of Toy</th>
                    <th>Total Quantity</th>
                    <th>Main Image</th>
                    <th>Preview 1</th>
                    <th>Preview 2</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["title"] . "</td>";
                        echo "<td>RM" . $row["price"] . "</td>";
                        echo "<td>" . $row["category"] . "</td>";
                        echo "<td>" . $row["typeoftoy"] . "</td>";
                        echo "<td>" . $row["totalQty"] . "</td>";

                        echo "<td> <img style='width: 100px; height:100px;' src='assets/" . $row["img"] . "'></td>";
                        if ($row["img_prev1"] == "") {
                            echo "<td> No Image </td>";
                        } else {
                            echo "<td> <img style='width: 100px; height:100px;' src='assets/" . $row["img_prev1"] . "'></td>";
                        }

                        if ($row["img_prev2"] == "") {
                            echo "<td> No Image </td>";
                        } else {
                            echo "<td> <img style='width: 100px; height:100px;' src='assets/" . $row["img_prev2"] . "'></td>";
                        }
                        if ($row["totalQty"] <= "5") {
                            echo "<td style='color: red; font-weight: bold; text-align: center;'> Low </td>";
                        } else {
                            echo "<td style='color: green; font-weight: bold; text-align: center;'> High </td>";
                        }
                        echo "<td>
                        <button class='action-btn' onclick=\"editItem(" . $row['id'] . ",'" . $row['title'] . "','" . $row['rating'] . "','" . $row['price'] . "','" . $row['category'] . "','" . $row['typeoftoy'] . "'," . $row['totalQty'] . ",'" . $row['shipsFrom'] . "')\">Edit</button>
                        <button class='action-btn' onclick=\"confirmDelete(" . $row['id'] . ")\">Delete</button>
                            </td>";
                        echo "</tr>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No data found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>

        <button class='new-prod-btn' onclick="addNewItem()">Add New Product</button>

        <div class='editSection' id="editSection" style="display: none; margin-top: 20px;">
            <h3 id="formHeader">Product Details</h3>
            <form id="editForm" method="post" enctype="multipart/form-data">
                <input type="hidden" id="itemId" name="id">

                <label for="itemTitle">Title:</label>
                <input type="text" id="itemTitle" name="title" required><br><br>

                <label for="itemRating">Rating:</label>
                <input type="text" id="itemRating" name="rating" required><br><br>

                <label for="itemPrice">Price:</label>
                <input type="text" id="itemPrice" name="price" required><br><br>

                <label for="itemCategory">Category:</label>
                <input type="text" id="itemCategory" name="category" required><br><br>

                <label for="itemType">Type of Toy:</label>
                <input type="text" id="itemType" name="typeoftoy" required><br><br>

                <label for="itemQty">Total Quantity:</label>
                <input type="number" id="itemQty" name="totalQty" required><br><br>

                <label for="itemShipsFrom">Ships From:</label>
                <input type="text" id="itemShipsFrom" name="shipsFrom" required><br><br>

                <label for="itemImage">Choose Image:</label>
                <input type="file" id="itemImage" name="image" accept="image/*"><br><br>

                <label for="img_prev1">Preview Image 1:</label>
                <input type="file" id="itemImage1" name="img_prev1" accept="image/*"><br><br>

                <label for="img_prev2">Preview Image 2:</label>
                <input type="file" id="itemImage2" name="img_prev2" accept="image/*"><br><br>

                <button type="submit" id="submitBtn">Save Changes</button>
            </form>
        </div>
    </div>
</body>

</html>

<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this item?")) {
            window.location.href = "delete_item.php?id=" + id;
        }
    }

    function editItem(id, title, rating, price, category, typeoftoy, totalQty, shipsFrom) {
        document.getElementById("editSection").style.display = "block";
        document.getElementById("itemId").value = id;
        document.getElementById("itemTitle").value = title;
        document.getElementById("itemRating").value = rating;
        document.getElementById("itemPrice").value = price;
        document.getElementById("itemCategory").value = category;
        document.getElementById("itemType").value = typeoftoy;
        document.getElementById("itemQty").value = totalQty;
        document.getElementById("itemShipsFrom").value = shipsFrom;
        document.getElementById("submitBtn").innerText = "Save Changes";
        document.getElementById("editForm").action = "edit_item.php"; // Set to update script
    }


    function addNewItem() {
        document.getElementById("editSection").style.display = "block";
        document.getElementById("editForm").reset(); // Clear form fields
        document.getElementById("itemId").value = ""; // Clear ID for new item
        document.getElementById("submitBtn").innerText = "Add Product";
        document.getElementById("editForm").action = "add_item.php"; // Set to add script
    }
</script>