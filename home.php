<?php
include("navigation.php");
?>

<html>
<link rel="stylesheet" href="./styles/home.css">

<script>
    function removeCookie() {
        // Create a new Date object to set the cookie's expiration date to the past
        var date = new Date();
        date.setTime(date.getTime() - 1); // Set to the past

        // Set the cookie with the same name but an empty value and an expiration date in the past
        document.cookie = "user_email=; expires=" + date.toUTCString() + "; path=/";

        // Optionally, reload the page to reflect the changes
        location.reload();
    }
</script>

<body>
    <div class="top-banner">
        <div style="text-align:center;">
            <img style="display:inline-block; height:100px;margin-right: 20px; position:relative;" src="assets/star.png" alt="">
            <h1
                style="letter-spacing: 10px;display:inline-flex;color:#C78383; font-size: 150px;text-align: center;">
                Stardust</h1>

        </div>
    </div>

    <div style="text-align: center; margin-left: 250px;">
        <div style="text-align:center;display:inline-block;">
            <p
                style="font-family: space mono;font-size: 36px;font-weight: bold;line-height: 53.32px;text-align: center;color:black;">
                Limited Time Only!</p>

            <h4 style="font-family: space mono;
            font-size: 30px;
            font-weight: 700;
            line-height: 71.09px;
            text-align: center;
            color: #DB7373;
            ">Up To 50%</h4>

            <button style="    
        width: 200px;
        height: 60px;
        font-size: 20px;
        font-family: space mono;
        gap: 0px;
        border-radius: 17px;
        opacity: 0px;
        background: #ECC182;text-align: center;" onclick="window.location.href='catelogue.php'">Shop</button>
        </div>

        <h1 style="letter-spacing: 10px; display:inline-flex; color:#DD836B;font-size:150px;text-align: right;">
            Limited</h1>
    </div>
    <h1
        style="letter-spacing: 10px;color:#DD836B;font-size: 165px;text-align: right;left:-50px;position:relative;">
        SALE!!
    </h1>


    <div style="background:#FBD68F;width:100%;">
        <p style="font-family: Pacifico;
        font-size: 30px;
        font-weight: 400;
        line-height: 84.29px;
        letter-spacing: 0.03em;
        text-align: center;
        color:#D9F1F3;
        ">playful • colorful • joyful • playful • colorful • joyful • playful • colorful • joyful • colorful • joyful • playful • colorful • joyful • playful</p>
    </div>

    <div>
        <img class="rabbit-side" src="assets/rabbit-side.png" alt="">
    </div>

    <div class="trending-section">
        <div style="background:#17324D; width:100%; padding-bottom:150px; text-align:center; position: relative; z-index: 1;    ">
            <h1 style="font-family: monospace;
        font-size: 80px;
        font-weight: 700;
        line-height: 189.57px;
        text-align: center;
        color:#ECC182;
        letter-spacing:5px;
        ">Trending</h1>
            <div class="cloud-background"></div>
            <div class="trending-items text-align:center;">
                <?php
                // Connect to the database
                $conn = new mysqli('localhost', 'root', '', 'stardust');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve trending items
                $sql = "SELECT * FROM items WHERE category='trending' LIMIT 3";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<a style="text-decoration: none; color: black;" href="http://localhost/stardust/stardust/product-page.php?id=' . $row["id"] . '&typeoftoy=jelly">';
                        echo '<div>';
                        echo '<div class="image-container-trend">';
                        echo '<img src="assets/' . $row["img"] . '" alt="' . $row["title"] . '">';
                        echo ' </div>';
                        echo '<div class="item">';
                        echo '<h3>' . $row["title"] . '</h3>'; //Title
                        echo '<p class="price">RM ' . $row["price"] . '</p>'; //Price
                        echo '</div>';
                        echo '</div>';
                        echo '</a>';
                    }
                } else {
                    echo "No trending items available.";
                }

                $conn->close();
                ?>
            </div>

            <a style="
                    position: relative;
                    z-index: 2;
                " href="http://localhost/stardust/stardust/category_toys.php?typeoftoy=jelly">
                <button class=' view-cat-btn' style="    
                        width: 15%;
                        height: 60px;
                        margin-left: -5px;
                        gap: 0px;
                        border-radius: 17px;
                        background: #A9D1FF;
                        margin-top:30px;
                        font-family: monospace;
                        text-align: center;
                        border: none;
                        z-index: 2;"

                    onclick="window.location.href='category_toys.php?category=trending'">
                    <p style="font-family: monospace;
                        font-size: 32px;
                        font-weight: 700;
                        line-height: 25px;
                        text-align: center;
                        color:#FFFFFF;
                        font-size: 20px;
                        ">View Jellycat</p>
                </button>
            </a>
        </div>
    </div>

    <div style="background:#FBD68F;width:100%;">
        <p style="font-family: Pacifico;
        font-size: 30px;
        font-weight: 400;
        line-height: 84.29px;
        letter-spacing: 0.03em;
        text-align: center;
        color:#C9ACE0;
        ">joyful • playful • colorful • joyful • playful . colorful . joyful . playful . colorful . joyful . playful . colorful . joyful. colorful . joyful .
            playful</p>
    </div>

    <section>

        <div style="background:#FEAFAB;">
            <h1 class="new-arrivals-new">New</h1>
            <div class="trending-items">
                <?php
                // Connect to the database
                $conn = new mysqli('localhost', 'root', '', 'stardust');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve trending items
                $sql = "SELECT * FROM items WHERE category='new' LIMIT 4";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div>';
                        echo '<a style="text-decoration: none; color: black;" href="http://localhost/stardust/stardust/product-page.php?id=' . $row['id'] . '&typeoftoy=sonny">';
                        echo '<div class="item-new">';
                        echo '<img class="trending-img" src="assets/' . $row["img"] . '" alt="' . $row["title"] . '">';
                        echo '</div>';
                        echo '<div class="item-new-text">';
                        echo '<h3>' . $row["title"] . '</h3>';
                        echo '<p class="trending-price">RM ' . $row["price"] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No trending items available.";
                }

                $conn->close();
                ?>
            </div>
            <div class='arr-btn'>
                <a class='arr-ctlg-btn' href="http://localhost/stardust/stardust/category_toys.php?typeoftoy=sonny"> <button class="brctlg-btn">View Sonny Angels</button> </a>
                <h1 class="new-arrivals-arrival">
                    Arrivals
                </h1>
            </div>
        </div>
    </section>



    <section>
        <div style="background:#FBD68F;width:100%; height: 200px">
            <p style="font-family: Pacifico;
                font-size: 70px;
                font-weight: 400;
                line-height: 183.58px;
                text-align: center;
                color:#F0FFA8;
                position: relative;
                font-style: italic;">Shop By Category</p>
        </div>
    </section>

    <div>
        <div class="planet-background">
            <div class="trending-items-cat">
                <a href="http://localhost/stardust/stardust/category_toys.php?typeoftoy=sonny">
                    <div class="card-cat">
                        <div class="image-container-cat">
                            <img src="assets/1.png">
                            <div class="overlay-cat"></div>
                            <div class="text-cat">
                                <h2>Sonny Angels</h2>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="http://localhost/stardust/stardust/category_toys.php?typeoftoy=smiski">
                    <div class="card-cat">
                        <div class="image-container-cat">
                            <img src="assets/2.png">
                            <div class="overlay-cat"></div>
                            <div class="text-cat">
                                <h2>Smiski</h2>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="http://localhost/stardust/stardust/category_toys.php?typeoftoy=jelly">
                    <div class="card-cat">
                        <div class="image-container-cat">
                            <img src="assets/3.png">
                            <div class="overlay-cat"></div>
                            <div class="text-cat">
                                <h2>Jellycat</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

</body>

</html>