<?php
require '../Config/Database.php';
require '../vendor/autoload.php'; // Path to the Stripe PHP library

\Stripe\Stripe::setApiKey('sk_test_51QEZsOEEn0kU8TJT6m5x6qtEhYdtqRk887PbWFWXcEb6C77taIZvh3CVol4nhrVaSUcIg5rfn9B2kePkzkyOBZLf00q9NmLt41'); // Replace with your secret key

// Get user email from cookies
$user_email = $_COOKIE['user_email'] ?? '';

if (!$user_email) {
    echo json_encode(['error' => 'User email is missing']);
    exit;
}

// Prepare and execute SQL query to fetch cart items for the user, including title
$sql = "SELECT cart.item_id, cart.quantity, items.price, items.title, cart.embroid, cart.color, cart.font, cart.price
        FROM cart 
        JOIN items ON cart.item_id = items.id 
        WHERE cart.user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$line_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (!isset($row['title'], $row['price'], $row['quantity']) || $row['quantity'] <= 0) {
            echo json_encode(['error' => 'Invalid product data for one or more items in the cart']);
            exit;
        }

        // Calculate the unit price by dividing the total price by the quantity
        $unit_price = ($row['price'] / $row['quantity']) * 100; // Stripe expects amount in cents

        $line_items[] = [
            'price_data' => [
                'currency' => 'myr',
                'product_data' => [
                    'name' => $row['title'],
                ],
                'unit_amount' => (int) $unit_price, // Ensure unit_amount is an integer for Stripe
            ],
            'quantity' => $row['quantity'],
        ];
    }
} else {
    echo json_encode(['error' => 'No items in the cart']);
    exit;
}

// Close the statement
$stmt->close();

// Create a checkout session
try {
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'http://localhost/stardust/stardust/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://localhost/stardust/stardust/cart.php',
    ]);

    // Return session ID as JSON
    header('Content-Type: application/json');
    echo json_encode(['id' => $checkout_session->id]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Stripe checkout session creation failed: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();
