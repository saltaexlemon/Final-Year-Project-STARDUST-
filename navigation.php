<link rel="stylesheet" href="./styles/nav.css">


<header>
    <div class="topnav">
        <div class="navigations">
            <div class="nav-left">
                <a href="home.php">
                    <h3 class="title">Stardust</h3>
                </a>
            </div>
            <div class="nav-center">
                <a href="home.php">
                    <h3 class="active">Home</h3>
                </a>
                <a href="catelogue.php">
                    <h3>Catalogue</h3>
                </a>
                <a href="products.php">
                    <h3>Products</h3>
                </a>
                <a href="embroid.php">
                    <h3 href="embroid.php">Embroidery</h3>
                </a>
                <a href="contact.php">
                    <h3>Contact</h3>
                </a>
                <a href="cart.php">
                    <h3>Cart</h3>
                </a>
            </div>
            <div class="nav-right">
                <?php
                if (isset($_COOKIE['user_email'])) {
                    $user_email = htmlspecialchars($_COOKIE['user_email']); // Get and sanitize the email
                    echo "
                <div class='account'>
                <a href='account.php'> <h3>$user_email</h3> </a>
                <img height='40px' src='assets/logout.webp' alt=''  onclick='removeCookie()'>
            </div>";
                } else {
                    echo "<a href='login-page.php'>
                    <div class='account'>
                        <a href='account.php'> <h3>account</h3> 
                    </div>
                    <img class='bag' height='40px' src='assets/Heart.png' alt=''>
                
          </a>";
                }
                ?>
            </div>
        </div>
    </div>
</header>