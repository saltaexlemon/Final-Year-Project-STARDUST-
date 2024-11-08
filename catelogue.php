<?php
include("navigation.php");

// Check if a category is specified in the URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Database connection
$conn = new mysqli('localhost', 'root', '', 'stardust');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Adjust SQL query to filter by category if specified
$sql = "SELECT * FROM items";
if ($category) {
    $sql .= " WHERE typeoftoy='" . $conn->real_escape_string($category) . "'";
}

$result = $conn->query($sql);
?>

<link rel="stylesheet" href="./styles/catalogue.css">

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

<body style="text-align:center;">

    <div style="background:#FFCCCA; display: flex; align-items: center; justify-content: center; ">

        <div style="display:inline-block;">
            <img style="height: 500px;" src="assets/dragon.png" />
        </div>

        <div style="display:inline-block; text-align:center;">
            <h4 style="
                font-size: 44px;
                font-weight: 400;
                font-weight: bold;
                letter-spacing: 0.03em;
                text-align: left;
                ">Jellycat</h4>

            <h1 style="font-family: monospace;
                font-size: 115px;
                font-weight: bold;
                text-align: left;
                display: block;
                ">Snow</h1>

            <h1 style="font-family: monospace;
                font-size: 115px;
                font-weight: bold;
                text-align: left;
                display: block;
                ">Dragon</h1>

            <h1 style="font-family: monospace;
                font-size: 48px;
                font-weight: 400;
                line-height: 71.09px;
                text-align: left;
                font-weight: bold;
                ">RM 599</h1>

            <a href="http://localhost/stardust/stardust/category_toys.php?typeoftoy=jelly"><button class="atc-btn">View Jellycats</button></a>
        </div>
    </div>


    <div style="text-align:center; margin-top:0px;">
        <h2 class="cat-headers">Jellycats</h2>

        <div class="card-div">
            <?php
            // Connect to the database
            $conn = new mysqli('localhost', 'root', '', 'stardust');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve trending items
            $sql = "SELECT * FROM items WHERE typeoftoy='jelly' LIMIT 4";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    echo '<a href="product-page.php?id=' . $row["id"] . '&typeoftoy=' . $row["typeoftoy"] . '">';
                    echo '<div class="card">';
                    echo '  <img src="assets/' . $row["img"] . '" alt="' . $row["title"] . '">';
                    echo '  <div class="jelly-title">';
                    echo $row["title"];
                    echo '  </div>';
                    echo '  <div class="price"> RM ' . $row["price"] . '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            } else {
                echo "No trending items available.";
            }

            $conn->close();
            ?>

        </div>

    </div>

    <button class="view-more-btn" onclick="window.location.href='category_toys.php?typeoftoy=jelly'">View More</button>

    <hr class="dividers" style="margin:20px;" />

    <div style="text-align:center; margin-top:0px;">
        <h2 class="cat-headers">Sonny Angels</h2>

        <div class="card-div">

            <?php
            // Connect to the database
            $conn = new mysqli('localhost', 'root', '', 'stardust');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve trending items
            $sql = "SELECT * FROM items WHERE typeoftoy='sonny' LIMIT 4";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    echo '<a href="product-page.php?id=' . $row["id"] . '&typeoftoy=' . $row["typeoftoy"] . '">';
                    echo '<div class="card">';
                    echo '  <img src="assets/' . $row["img"] . '" alt="' . $row["title"] . '">';
                    echo '  <div class="sonny-title">';
                    echo $row["title"];
                    echo '  </div>';
                    echo '  <div class="price"> RM ' . $row["price"] . '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            } else {
                echo "No trending items available.";
            }

            $conn->close();
            ?>
        </div>


    </div>

    <button class="view-more-btn" onclick="window.location.href='category_toys.php?typeoftoy=sonny'">View More</button>

    <hr class="dividers" style="margin:20px" />

    <div style="text-align:center; margin-top:0px;">
        <h2 class="cat-headers">Smiski</h2>

        <div class="card-div">

            <?php
            // Connect to the database
            $conn = new mysqli('localhost', 'root', '', 'stardust');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve trending items
            $sql = "SELECT * FROM items WHERE typeoftoy='smiski' LIMIT 4";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    echo '<a href="product-page.php?id=' . $row["id"] . '&typeoftoy=' . $row["typeoftoy"] . '">';
                    echo '<div class="card">';
                    echo '  <img src="assets/' . $row["img"] . '" alt="' . $row["title"] . '">';
                    echo '  <div class="smiski-title">';
                    echo $row["title"];
                    echo '  </div>';
                    echo '  <div class="price"> RM ' . $row["price"] . '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            } else {
                echo "No trending items available.";
            }

            $conn->close();
            ?>
        </div>


    </div>

    <button class="view-more-btn" onclick="window.location.href='category_toys.php?typeoftoy=smiski'">View More</button>

    <hr class="dividers-bottom" style="margin:20px; border-radius: 20px;" />

</body>

</html>