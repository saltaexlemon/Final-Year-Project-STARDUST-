<?php
include("../Config/Database.php");
include("navigation.php");

// Get user ID from cookies
$user_email = $_COOKIE['user_email'] ?? '';

// Fetch cart items from the database, including totalQty
$sql = "SELECT cart.id AS cart_id, items.title, items.img, items.price, cart.quantity, items.totalQty, cart.embroid, cart.color, cart.font
        FROM cart 
        JOIN items ON cart.item_id = items.id 
        WHERE cart.user_email = '$user_email'";
$result = $conn->query($sql);
?>

<html>
<link rel="stylesheet" href="./styles/cart.css">
<script src="https://js.stripe.com/v3/"></script>

<body>

    <div class="cart-container">
        <div class="cart-header">Cart</div>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='cart-item' data-total-qty='" . $row['totalQty'] . "'>";
                echo "<img src='assets/" . $row['img'] . "' alt='" . $row['title'] . "'>";
                echo "<div class='cart-details'>";
                echo "<h3>" . $row['title'] . "</h3>";
                if ($row["embroid"] == "withemb") {
                    $row['embroid'] = "Embroided";
                    echo "<h3>" . $row['embroid'] . ", " . $row['color'] . ", " . $row['font'] . "</h3>";
                } else if ($row["embroid"] == NULL) {
                    echo "";
                }
                echo "<p>Price: RM " . $row['price'] . "</p>";
                echo "<p class='qty-control'>Quantity: <input class='styled-input' type='number' value='" . $row['quantity'] . "' min='1' max='" . $row['totalQty'] . "'></p>";
                echo "</div>";
                echo "<div class='cart-controls'>";
                echo "<span class='remove-item' data-cart-id='" . $row['cart_id'] . "'>&times;</span>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>Your cart is empty.</p>";
        }
        ?>

        <div class="total-btn">
            <div class="total-price"> </div>
            <button class="checkout-btn">Checkout</button>
        </div>

    </div>

    <script>
        document.querySelectorAll('.remove-item').forEach(item => {
            item.addEventListener('click', function() {
                let cartId = this.getAttribute('data-cart-id');

                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', 'remove_from_cart.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            location.reload();
                        } else {
                            alert('Error: Could not remove item from cart.');
                        }
                    };
                    xhr.send('cart_id=' + cartId);
                }
            });
        });

        document.querySelectorAll('.cart-item input[type="number"]').forEach(item => {
            item.addEventListener('change', function() {
                let cartItem = this.closest('.cart-item');
                let cartId = cartItem.querySelector('.remove-item').getAttribute('data-cart-id');
                let newQuantity = parseInt(this.value);
                let maxQty = parseInt(cartItem.getAttribute('data-total-qty'));

                if (newQuantity > maxQty) {
                    alert(`Cannot exceed available stock of ${maxQty}.`);
                    this.value = maxQty; // Set input to maxQty
                    newQuantity = maxQty;
                }

                // Send an AJAX request to update the quantity
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_quantity.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        calculateTotalPrice(); // Update total price
                    } else {
                        alert('Error: Could not update quantity.');
                    }
                };
                xhr.send('cart_id=' + cartId + '&quantity=' + newQuantity);
            });
        });

        function calculateTotalPrice() {
            let total = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                let price = parseFloat(item.querySelector('p').textContent.replace('Price: RM ', ''));
                let quantity = parseInt(item.querySelector('input[type="number"]').value);
                total += price * quantity;
            });
            document.querySelector('.cart-container .total-price').textContent = "Total: RM " + total.toFixed(2);
            var element = document.querySelector('.total-price');
            element.value = total;
        }

        // Initial call to set total price
        calculateTotalPrice();

        const stripe = Stripe('pk_test_51QEZsOEEn0kU8TJT40IU1Ek8PcULoQMyyOR7wVeOwp62totGye2PUJ7KZJFwkE8PLqvFcxvSpO2O6RV5MkU8T9kh0053w6q4ge'); // Replace with your public key


        document.querySelector('.checkout-btn').addEventListener('click', async function() {
            let response = await fetch('checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            let session = await response.json();
            if (session.id) {
                stripe.redirectToCheckout({
                    sessionId: session.id
                });
            } else {
                alert('Error: Could not create checkout session.');
            }
        });
    </script>

</body>

</html>