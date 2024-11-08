<!DOCTYPE html>
<html>
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

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background-color: #003366;
        color: #fff;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .cart-item img {
        width: 100px;
        border-radius: 10px;
    }

    .cart-details {
        flex: 1;
        margin-left: 20px;
    }

    .cart-details h3 {
        margin: 0;
        font-size: 18px;
    }

    .cart-details p {
        margin: 5px 0;
        font-size: 14px;
    }

    .cart-controls {
        display: flex;
        align-items: center;
    }

    .cart-controls input[type='number'] {
        width: 40px;
        margin: 0 10px;
    }

    .remove-item {
        color: #FF5555;
        font-size: 24px;
        cursor: pointer;
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
    }

    body {
        background-color: #E7FDFF;
        margin: 0px !important;
        font-family: "Pacifico", cursive;
        font-weight: 400;
        font-style: normal;
    }

    .account {
        display: flex;
        align-items: center;

    }

    .navigations {
        display: flex;
        justify-content: space-around;
    }

    .cart-button {
        background-color: #1D3C55;
        color: #FFFFFF;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        font-weight: bold;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
    }
</style>

<body>

    <div class="topnav">
        <div class="navigations">
            <h3>Stardust</h3>
            <h3 class="active" href="#home">Home</h3>
            <a href="catelogue.php">
                <div>
                    <h3>Catalogue</h3>
                </div>
            </a>
            <h3 href="#contact">Contact</h3>
            <h3 href="#about">About</h3>
            <a href="login-page.php">
                <div class="account">
                    <h3>account</h3>

                    <img height="40px" src="assets/cart.png" alt="">
                </div>
            </a>

            <h3 href="#about">Cart</h3>
        </div>
    </div>

    <div class="cart-container">
        <div class="cart-header">Payment Success</div>

        <h4 style="color:#004B80; text-align:center;">yay! your payment was successful!</h4>


        <button class="checkout-btn" onclick="window.location.href='home.php'">Back to Home</button>
    </div>

</body>

</html>