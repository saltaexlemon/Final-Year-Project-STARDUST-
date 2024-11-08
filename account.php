<?php
include("navigation.php");

if (!isset($_COOKIE['user_email'])) {
    header("Location: login-page.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'stardust';
$user = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

$user_email = isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : '';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch user information based on email
if ($user_email) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display user information
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo '<div class="container">';
        echo '<h2>User Information</h2>';
        echo '<p>Name: <span>' . htmlspecialchars($user['name']) . '</span></p>';
        echo '<p>Email: <span>' . htmlspecialchars($user['email']) . '</span></p>';
        echo '<p>Contact: <span>' . htmlspecialchars($user['contact']) . '</span></p>';
        echo '<p>Shipping Address: <span>' . htmlspecialchars($user['address']) . '</span></p>';
        echo '<a class="edit-acc-btn" href="edit_account.php"><button >Edit Details</button></a>';
        echo '</div>';
    } else {
        echo "User not found.";
    }


    $stmt->close();
} else {
    echo "No user email found in cookies.";
}

if ($user_email) {
    // Query to retrieve orders data with item details based on user email
    $sql = "
        SELECT orders.id, orders.quantity, orders.price, orders.embroid, orders.color, 
               orders.font, orders.stripe_payment_id, orders.status, items.title 
        FROM orders
        INNER JOIN items ON orders.item_id = items.id
        WHERE orders.user_email = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="purchase-container">';
        echo '<h2>Recent Purchases</h2>';
        echo '<table>';
        echo '<thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Embroid</th>
                    <th>Color</th>
                    <th>Font</th>
                    <th>Purchase ID</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>';
        echo '<tbody>';

        // Fetch and display each order row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
            echo '<td style="text-align: center;">' . htmlspecialchars($row['quantity']) . '</td>';
            echo '<td>' . htmlspecialchars($row['price']) . '</td>';
            echo '<td>' . ($row['embroid'] == "withemb" ? "Yes" : "No") . '</td>';
            echo '<td>' . htmlspecialchars($row['color']) . '</td>';
            echo '<td>' . htmlspecialchars($row['font']) . '</td>';
            echo '<td>' . htmlspecialchars($row['stripe_payment_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['status']) . '</td>';

            // Add a Cancel button if status is 'awaiting'
            if ($row['status'] == 'Awaiting') {
                echo '<td> <form style="margin-top: 20px;" method="post" action="cancel_order.php" onsubmit="return confirm(\'Are you sure you want to cancel this order?\');">
                          <input type="hidden" name="order_id" value="' . $row['id'] . '">
                          <button style="border: none;
                            border-radius: 12px;
                            font-weight: bold;
                            font-size: 15px;
                            width: 100px;
                            height: 30px;
                            background-color: #fbdee2;" type="submit">Cancel</button>
                      </form></td>';
            } else {
                echo '<td style="font-size: 15px; text-align: center;">No Action</td>'; // No action available if status is not 'awaiting'
            }
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo "No orders found for this user.";
    }

    $stmt->close();
} else {
    echo "No user email found in cookies.";
}

$conn->close();
?>

<link rel="stylesheet" href="./styles/account.css">
<a class="to-home-btn" href="home.php"> <button> Home </button> </a>