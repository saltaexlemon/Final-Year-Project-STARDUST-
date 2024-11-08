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

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/user-list.css">
</head>

<body>

    <div class="content">
        <h3 style="text-align:end;">Welcome back, Admin</h3>
        <p>Users</p>

        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr onclick=\"showPurchases('" . $row["email"] . "')\">";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["contact"] . "</td>";
                        echo "<td>" . $row["address"] . "</td>";
                        echo "<td>
                            <button class='action-btn' onclick=\"editUser(" . $row['id'] . ",'" . $row['name'] . "','" . $row['email'] . "','" . $row['contact'] . "','" . $row['address'] . "')\">Edit</button>
                            <button class='action-btn' onclick=\"confirmDelete(" . $row['id'] . ")\">Delete</button>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No data found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>

        <!-- Edit Section -->
        <div class='editSection' id="editSection" style="display: none; margin-top: 20px;">
            <h3>Edit User</h3>
            <form action="update_user.php" method="post">
                <input type="hidden" id="userId" name="id">

                <label for="userName">Name:</label>
                <input type="text" id="userName" name="name" required><br><br>

                <label for="userEmail">Email:</label>
                <input type="email" id="userEmail" name="email" required><br><br>

                <label for="userContact">Contact:</label>
                <input type="text" id="userContact" name="contact" required><br><br>

                <label for="userAddress">Address:</label>
                <textarea id="userAddress" name="address" required></textarea><br><br>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

</body>

</html>

<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = "delete_user.php?id=" + id;
        }
    }

    function editUser(id, name, email, contact, address) {
        document.getElementById("editSection").style.display = "block";
        document.getElementById("userId").value = id;
        document.getElementById("userName").value = name;
        document.getElementById("userEmail").value = email;
        document.getElementById("userContact").value = contact;
        document.getElementById("userAddress").value = address;
    }


    function showPurchases(email) {
        fetch('get_user_purchases.php?email=' + email)
            .then(response => response.json())
            .then(data => {
                let purchasesContent = '<table><tr><th>Stripe Payment ID</th><th>Item ID</th><th>Product Name</th><th>Quantity</th><th>Total Amount</th><th>Status</th></tr>';
                data.forEach(purchase => {
                    purchasesContent += `<tr>
                    <td>${purchase.stripe_payment_id}</td>
                    <td>${purchase.item_id}</td>
                    <td>${purchase.product_name}</td>
                    <td>${purchase.quantity}</td>
                    <td>$${purchase.totalAmount}</td>
                    <td>
                        <select class='select-tracking' id="status-${purchase.stripe_payment_id}" onchange="updateStatus('${purchase.stripe_payment_id}')">
                            <option value="Awaiting" ${purchase.status === 'Awaiting' ? 'selected' : ''}>Awaiting</option>
                            <option value="Packed" ${purchase.status === 'Packed' ? 'selected' : ''}>Packed</option>
                            <option value="Shipped" ${purchase.status === 'Shipped' ? 'selected' : ''}>Shipped</option>
                            <option value="Complete" ${purchase.status === 'Complete' ? 'selected' : ''}>Complete</option>
                        </select>
                    </td>
                </tr>`;
                });
                purchasesContent += '</table>';

                document.getElementById('purchasesContent').innerHTML = purchasesContent;
                document.getElementById('purchasesModal').style.display = 'block';
            })
            .catch(error => console.error('Error fetching purchases:', error));
    }

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


    function closeModal() {
        document.getElementById('purchasesModal').style.display = 'none';
    }
</script>