<?php
include("navigation.php");
require '../Config/Database.php';
require '../vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51QEZsOEEn0kU8TJT6m5x6qtEhYdtqRk887PbWFWXcEb6C77taIZvh3CVol4nhrVaSUcIg5rfn9B2kePkzkyOBZLf00q9NmLt41'); // Replace with your secret key

$session_id = $_GET['session_id'] ?? '';
$user_email = $_COOKIE['user_email'] ?? '';
$success = false;
$status = "Awaiting";

if ($session_id && $user_email) {
    try {
        $session = \Stripe\Checkout\Session::retrieve($session_id);
        $payment_intent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

        // Fetch cart items for the user
        $sql = "SELECT cart.item_id, cart.quantity, items.price, cart.embroid, cart.color, cart.font
                FROM cart 
                JOIN items ON cart.item_id = items.id 
                WHERE cart.user_email = '$user_email'";
        $result = $conn->query($sql);

        $totalAmount = 0; // Initialize totalAmount

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Calculate the price for each item by multiplying price by quantity
                $itemTotal = $row['price'] * $row['quantity'];
                $totalAmount += $itemTotal; // Add item total to totalAmount

                // Insert order details into the orders table
                $stmt = $conn->prepare("INSERT INTO orders 
                    (user_email, item_id, quantity, price, embroid, color, font, stripe_payment_id, totalAmount, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param(
                    'siidssssds',
                    $user_email,
                    $row['item_id'],
                    $row['quantity'],
                    $row['price'],
                    $row['embroid'],
                    $row['color'],
                    $row['font'],
                    $payment_intent->id,
                    $totalAmount,
                    $status
                );
                $stmt->execute();

                // Deduct purchased quantity from totalQty in the items table
                $update_sql = "UPDATE items SET totalQty = totalQty - ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param('ii', $row['quantity'], $row['item_id']);
                $update_stmt->execute();
            }

            // Clear cart for the user
            $conn->query("DELETE FROM cart WHERE user_email = '$user_email'");
            $success = true;
        }
    } catch (Exception $e) {
        $success = false;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="styles/cart.css">
    <style>
        .cart-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-header {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: #004B80;
            margin-bottom: 20px;
        }

        .checkout-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #003366;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            width: auto;
        }

        body {
            background-color: #E7FDFF;
            margin: 0px !important;
            font-family: "Pacifico", cursive;
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>

<body>

    <div class="cart-container">
        <div class="cart-header">Payment Success</div>

        <?php if ($success): ?>
            <h4 style="color:#004B80; text-align:center;">Yay! Your payment was successful!</h4>
            <p style="text-align: center;">Thank you for your purchase. Your order has been processed, and you’ll receive a confirmation soon.</p>
        <?php else: ?>
            <h4 style="color:#FF5555; text-align:center;">Error: Payment not completed</h4>
            <p style="text-align: center;">Unfortunately, we couldn’t process your payment. Please contact support if you continue to experience issues.</p>
        <?php endif; ?>

        <button class="checkout-btn" onclick="window.location.href='home.php'">Back to Home</button>
    </div>

</body>

</html>