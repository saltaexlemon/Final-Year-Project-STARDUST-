<?php
include("../Config/Database.php");

// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and decode the data sent from the client
    $totalAmount = $_POST['total_amount'] ?? 0;
    $cartItems = json_decode($_POST['cart_items'], true);
    $paymentId = $_POST['payment_id'] ?? '';

    // Get user email from cookies
    $user_email = $_COOKIE['user_email'] ?? '';

    // Check if data is valid
    if (empty($user_email) || empty($cartItems) || empty($totalAmount) || empty($paymentId)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
        exit;
    }

    try {
        // Begin transaction
        $conn->begin_transaction();

        // Prepare and execute the order insert query
        $orderSql = "INSERT INTO orders (user_email, total_amount, payment_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($orderSql);
        $stmt->bind_param("sds", $user_email, $totalAmount, $paymentId);

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert order: " . $stmt->error);
        }
        $orderId = $stmt->insert_id; // Get the generated order ID for this transaction

        // Insert each item in the order_items table
        $itemSql = "INSERT INTO order_items (order_id, title, quantity, embroid, color, font, price) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $itemStmt = $conn->prepare($itemSql);

        foreach ($cartItems as $item) {
            $itemStmt->bind_param(
                "isisssd",
                $orderId,
                $item['title'],
                $item['quantity'],
                $item['embroid'],
                $item['color'],
                $item['font'],
                $item['price']
            );

            if (!$itemStmt->execute()) {
                throw new Exception("Failed to insert order item: " . $itemStmt->error);
            }
        }

        // Clear the cart after order completion
        $deleteCartSql = "DELETE FROM cart WHERE user_email = ?";
        $deleteCartStmt = $conn->prepare($deleteCartSql);
        $deleteCartStmt->bind_param("s", $user_email);

        if (!$deleteCartStmt->execute()) {
            throw new Exception("Failed to clear cart: " . $deleteCartStmt->error);
        }

        // Commit transaction
        $conn->commit();

        echo json_encode(['status' => 'success', 'message' => 'Order successfully submitted!']);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();

        // Return error message to the client
        echo json_encode(['status' => 'error', 'message' => 'Transaction failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
