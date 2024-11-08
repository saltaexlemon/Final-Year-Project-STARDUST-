<?php
include("navigation.php");
?>

<link rel="stylesheet" href="./styles/category_toys.css">

<body>
    <div style="text-align:center; margin-top:50px;">
        <?php
        $typeOfToy = $_GET['typeoftoy'] ?? '';
        echo '<div class="header">';
        if ($typeOfToy == 'sonny') {
            echo '<h1> Sonny angels </h1>';
        } else if ($typeOfToy == 'smiski') {
            echo '<h1> Smiski </h1>';
        } else if ($typeOfToy == 'jelly') {
            echo '<h1> Jellycats </h1>';
        };
        echo '</div>';
        ?>
        <div class="card-div">
            <?php
            // Path to your star image
            $starImagePath = 'assets/star.png';
            // Connect to the database
            $conn = new mysqli('localhost', 'root', '', 'stardust');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($typeOfToy != null) {
                // Retrieve items based on type
                $sql = "SELECT * FROM items WHERE typeoftoy='$typeOfToy'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="product-cat-container">';
                        echo '<a href="product-page.php?id=' . $row["id"] . '&typeoftoy=' . $row["typeoftoy"] . '">';
                        echo '<div class="card">';
                        echo '  <img src="assets/' . $row["img"] . '" alt="' . $row["title"] . '">';
                        echo '  <div class="title">' . $row["title"] . '</div>';

                        for ($i = 0; $i < $row['rating']; $i++) {
                            echo '<img style="display:inline-flex;" src="' . $starImagePath . '" alt="star" width="20px" height="20px">';
                        }
                        echo '  <div class="price">' . $row["price"] . '</div>';
                        echo '</div>';
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    echo "No trending items available.";
                }
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>