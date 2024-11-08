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

// Fetch transaction data
$sql = "SELECT id, user_email, item_id, quantity, price, embroid, color, font, stripe_payment_id, created_at, totalAmount, status 
        FROM orders 
        ORDER BY stripe_payment_id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/admin-transaction.css">
</head>

<body>
    <div class="content">
        <h3 style="text-align:center;">Transaction Data</h3>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Email</th>
                    <th>Item ID</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Embroidery</th>
                    <th>Color</th>
                    <th>Font</th>
                    <th>Stripe Payment ID</th>
                    <th>Created At</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["user_email"] . "</td>";
                        echo "<td>" . $row["item_id"] . "</td>";
                        echo "<td>" . $row["quantity"] . "</td>";
                        echo "<td>MYR" . $row["price"] . "</td>";
                        if ($row["embroid"] == "") {
                            echo "<td> - </td>";
                        } else {
                            echo "<td>" . $row["embroid"] . "</td>";
                        }
                        if ($row["color"] == NULL) {
                            echo "<td> - </td>";
                        } else {
                            echo "<td>" . $row["color"] . "</td>";
                        }
                        if ($row["font"] == NULL) {
                            echo "<td> - </td>";
                        } else {
                            echo "<td>" . $row["font"] . "</td>";
                        }
                        echo "<td>" . $row["stripe_payment_id"] . "</td>";
                        echo "<td>" . $row["created_at"] . "</td>";
                        echo "<td>MYR" . $row["totalAmount"] . "</td>";
                        echo "<td>
                            <select class='select-tracking' id='status-" . $row["stripe_payment_id"] . "' onchange=\"updateStatus('" . $row["stripe_payment_id"] . "')\">
                                <option value='Awaiting' " . ($row["status"] === 'Awaiting' ? 'selected' : '') . ">Awaiting</option>
                                <option value='Packed' " . ($row["status"] === 'Packed' ? 'selected' : '') . ">Packed</option>
                                <option value='Shipped' " . ($row["status"] === 'Shipped' ? 'selected' : '') . ">Shipped</option>
                                <option value='Complete' " . ($row["status"] === 'Complete' ? 'selected' : '') . ">Complete</option>
                            </select>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No transaction data found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>

<script>
    function updateStatus(stripePaymentId) {
        const selectedStatus = document.getElementById(`status-${stripePaymentId}`).value;

        // Make an API call to update the status in the database
        fetch('update_order_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: stripePaymentId,
                    status: selectedStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Status updated successfully');
                } else {
                    alert('Failed to update status');
                }
            })
            .catch(error => console.error('Error updating status:', error));
    }
</script>