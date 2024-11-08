<?php
include("navigation.php");
?>

<link rel="stylesheet" href="./styles/login.css">


<body>
    <div style="
            position: relative;
            top: -5%;
            margin: auto;
            text-align: center;">
        <div class="container">
            <div class="login-box">
                <form action="login.php" method="POST" class="register-form">
                    <h2 class="login-title">login</h2>

                    <input type="email" name="email" placeholder="email" id="email" required>
                    <input type="password" name="password" placeholder="password" id="password" required>

                    <p class="forgot-password"><a
                            href="forgot-password-page.php">forgot password?</a></p>

                    <div class="checkbox-container">
                        <input type="checkbox" id="remember">
                        <label for="remember">remember me</label>
                    </div>

                    <button class="submit-btn-login" type="submit">login</button>

                    <p><a class="cna-text" href="register-page.php">Create new account</a></p>
                </form>
            </div>
            <div><img class='logo-background' src="assets/stardust-remove-bg.png"></div>
        </div>



    </div>




</body>

</html>