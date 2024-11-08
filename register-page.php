<?php
include("navigation.php");
?>

<link rel="stylesheet" href="./styles/register.css">

<!-- <header>
    <div class="topnav">
        <div class="navigations">
            <a href="home.php">
                <h3 class="title">Stardust</h3>
            </a>

            <a href="home.php">
                <h3 class="active">Home</h3>
            </a>

            <a href="catelogue.php">
                <div>
                    <h3>Catalogue</h3>
                </div>
            </a>

            <a href="contact.php">
                <h3>Contact</h3>
            </a>

            <a href="embroid.php">
                <h3 href="embroid.php">Embroidery</h3>
            </a>

            <a href="cart.php">
                <h3>Cart</h3>
            </a>

            <?php
            if (isset($_COOKIE['user_email'])) {
                $user_email = htmlspecialchars($_COOKIE['user_email']); // Get and sanitize the email
                echo "
                <div class='account'>
                <a href='account.php'> <h3>$user_email</h3> </a>
                <img height='40px' src='assets/logout.webp' alt=''  onclick='removeCookie()'>
            </div>";
            } else {
                // If the cookie is not set, show the account link
                echo "<a href='login-page.php'>
                <div class='account'>
                    <a href='account.php'> <h3>account</h3> </a>
                    <img class='bag' height='40px' src='assets/cart.png' alt=''>
                </div>
          </a>";
            }
            ?>
        </div>

    </div>
</header> -->

<body>
    <div style="
     position: relative;
        top: -15%;
        margin: auto;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    ">
        <div class="container">
            <div class="register-box">
                <form action="register.php" method="POST" class="register-form">
                    <h2>register</h2>

                    <input type="text" name="name" placeholder="name" id="name" required>
                    <input type="email" name="email" placeholder="email" id="email" required>
                    <input type="password" name="password" placeholder="password" id="password" required>
                    <input type="tel" name="contact" placeholder="contact number" id="contact" required>
                    <input type="text" name="address" placeholder="address" id="address" required>

                    <button class='register-btn' type="submit">register</button>
                    <p><a class="cna-text" href="login-page.php">To Login </a></p>

                </form>
            </div>
            <div><img class='logo-background' src="assets/stardust-remove-bg.png"></div>
        </div>
    </div>


</body>

</html>