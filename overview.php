<?php
include("admin-sidebar.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="./styles/admin-overview.css">
</head>

<body>
    <div class="content">
        <h3 style="text-align:end;">Welcome back, Admin</h3>
        <p class="title-admin">Overview</p>

        <div class="card-container">
            <div class="card">
                <h4>Purchases</h4>
                <canvas id="purchasesChart"></canvas>
            </div>
            <div class="card">
                <h4>Sales Amount</h4>
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <h3 class="overview-table-title">Recent Purchases</h3>
        <div class="table-recent">
            <table>
                <thead>
                    <tr>
                        <th>Purchase Reference</th>
                        <th>User Email</th>
                        <th>Item Id</th>
                        <th>Quantity</th>
                        <th>RM</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $host = 'localhost';
                    $dbname = 'stardust';
                    $user = 'root';
                    $password = '';

                    $conn = new mysqli($host, $user, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT *, orders.stripe_payment_id, orders.user_email, items.title AS product_title, orders.quantity 
            FROM orders 
            JOIN items ON orders.item_id = items.id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["stripe_payment_id"] . "</td>";
                            echo "<td>" . $row["user_email"] . "</td>";
                            echo "<td>" . $row["product_title"] . "</td>"; // Display product title
                            echo "<td>" . $row["quantity"] . "</td>";
                            echo "<td>" . $row["totalAmount"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No data found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>

            </table>
        </div>

        <script>
            function updateStatus(id, status) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "update_status.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert("Status updated successfully");
                    }
                };
                xhr.send("id=" + id + "&status=" + status);
            }
        </script>

        <?php
        $conn = new mysqli($host, $user, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $itemsResult = $conn->query("SELECT id, title FROM items");
        $items = [];
        $itemIds = [];

        while ($row = $itemsResult->fetch_assoc()) {
            $items[] = $row['title'];
            $itemIds[] = $row['id'];
        }

        $purchasesResult = $conn->query("SELECT item_id, SUM(quantity) as total_quantity FROM orders GROUP BY item_id");
        $purchasesData = array_fill_keys($itemIds, 0);

        while ($row = $purchasesResult->fetch_assoc()) {
            $purchasesData[$row['item_id']] = (int) $row['total_quantity'];
        }

        $salesData = array_fill_keys($itemIds, 0);
        $salesResult = $conn->query("SELECT item_id, SUM(totalAmount) as total_sales FROM orders GROUP BY item_id");

        while ($row = $salesResult->fetch_assoc()) {
            $salesData[$row['item_id']] = (float) $row['total_sales'];
        }

        $conn->close();
        ?>

        <script>
            const ctx = document.getElementById('purchasesChart').getContext('2d');
            const purchasesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($items); ?>,
                    datasets: [{
                        label: 'Purchases',
                        data: <?php echo json_encode(array_values($purchasesData)); ?>,
                        backgroundColor: '#FBD5B0',
                        borderColor: '#FBD5B0',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctxSales = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctxSales, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($items); ?>,
                    datasets: [{
                        label: 'Sales Amount',
                        data: <?php echo json_encode(array_values($salesData)); ?>,
                        backgroundColor: '#B5E4EA',
                        borderColor: '#B5E4EA',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
</body>

</html>