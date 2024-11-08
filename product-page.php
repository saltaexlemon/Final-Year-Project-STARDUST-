<?php
include("navigation.php");
?>
<link rel="stylesheet" href="./styles/product-page.css">

<?php
// Check if the required parameters are set in the URL
if (isset($_GET['id']) && isset($_GET['typeoftoy'])) {
    $itemId = $_GET['id'];
    $typeOfToy = $_GET['typeoftoy'];

    // Set background color based on the type of toy
    $backgroundColor = '#FFFFFF'; // default background
    if ($typeOfToy == 'smiski') {
        $backgroundColor = '#DBFFD8';
    } elseif ($typeOfToy == 'sonny') {
        $backgroundColor = '#F5E9D6';
    } elseif ($typeOfToy == 'jelly') {
        $backgroundColor = '#ECFEFF';
    }

    $toyCategory = '';
    if ($typeOfToy == 'smiski') {
        $toyCategory = 'Smiski';
    } elseif ($typeOfToy == 'sonny') {
        $toyCategory = 'Sonny';
    } elseif ($typeOfToy == 'jelly') {
        $toyCategory = 'Jellycat';
    }

    $titleColor = '#FFFFFF'; // title color
    if ($typeOfToy == 'smiski') {
        $titleColor = '#497052';
    } elseif ($typeOfToy == 'sonny') {
        $titleColor = '#ECC182';
    } elseif ($typeOfToy == 'jelly') {
        $titleColor = '#A9D1FF';
    }

    $backgroundImg = '#FFFFFF'; // default background
    if ($typeOfToy == 'smiski') {
        $backgroundImg = 'assets/green-footer.png';
    } elseif ($typeOfToy == 'sonny') {
        $backgroundImg = 'assets/blue-footer.png';
    } elseif ($typeOfToy == 'jelly') {
        $backgroundImg = 'assets/blue-footer.png';
    }

    // Path to your star image
    $starImagePath = 'assets/star.png';

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'stardust');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve item details based on the ID
    $sql = "SELECT * FROM items WHERE id='$itemId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the item details
        $item = $result->fetch_assoc();
        echo "<body style='background-color: $backgroundColor; width:auto; text-align:center;'>";
        echo "<div style='display:flex; margin-top:100px; justify-content:space-evenly; position: relative;'>";

        // Display main item image and title
        echo "<div>";
        echo "<img id='mainImage' style='position: relative; height:500px;' src='assets/" . $item['img'] . "' alt='" . $item['title'] . "'>";
        // Display image preview boxes
        echo "<div style='display: flex; justify-content: center; margin-top: 20px; gap: 20px;'>";

        // Check if preview images exist in the database, then display them
        if (!empty($item['img_prev1'])) {
            echo "<div style='text-align:center;'>";
            echo "<img style='padding:10px; margin-bottom:10px; border-radius: 10%; border:3px solid $titleColor; height: 150px; cursor: pointer;' src='assets/" . $item['img_prev1'] . "' alt='Preview 1' onclick=\"changeMainImage('assets/" . $item['img_prev1'] . "')\">";
            echo "</div>";
        }
        if (!empty($item['img_prev2'])) {
            echo "<div style='text-align:center;'>";
            echo "<img style='padding:10px; margin-bottom:10px; border-radius: 10%; border:3px solid $titleColor; height: 150px; cursor: pointer;' src='assets/" . $item['img_prev2'] . "' alt='Preview 2' onclick=\"changeMainImage('assets/" . $item['img_prev2'] . "')\">";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
        echo "<div>";
        echo "<h4 class='prod-category'> $toyCategory</h4>";
        echo "<h1 class='prod-title'>" . $item['title'] . "</h1>";

        // Display rating stars and price
        echo "<div class='rating-price'>";
        for ($i = 0; $i < $item['rating']; $i++) {
            echo '<img src="' . $starImagePath . '" alt="star" width="20px" height="20px">';
        }
        echo "<p>MYR " . $item['price'] . "</p>";
        echo "</div>";
        if ($item["totalQty"] < 5) {
            echo "<p style='text-align: left; color: red; font-size: 20px; font-family: monospace;'> [Low stock] " . $item['totalQty'] . " available! </p>";
        } else if ($item["totalQty"] == 0) {
            echo "<p> </p>";
        };

        // Show Add to Cart and quantity options for non-Jellycat items
        if ($typeOfToy != 'jelly') {
            if ($item["totalQty"] == 0) {
                echo "<p style='font-size: 30px; font-family: monospace; font-weight: bold;'> Item is out of stock! </p>";
            } else {
                echo "
        <form action='add_to_cart.php' method='POST' class='cart-form'>
            <input type='hidden' name='item_id' value='" . $item['id'] . "'>
            <input type='hidden' name='user_email' value='" . $_COOKIE['user_email'] . "'>
            <input type='hidden' name='price' value='" . $item['price'] . "'>
            <div class='cart-container' style='display:flex;'>
                <button type='submit'
                    style='background-color: $titleColor;
                    color: #FFFFFF;
                    border: none;
                    border-radius: 10px;
                    padding: 10px 20px;
                    font-size: 16px;
                    cursor: pointer;
                    font-weight: bold;
                    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);' >
                    Add To Cart
                </button>
                <div disable class='quantity-dropdown'>
                    <select name='quantity' style='background-color: $titleColor !important;'>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                        <option value='4'>4</option>
                        <option value='5'>5</option>
                        <option value='6'>6</option>
                        <option value='7'>7</option>
                        <option value='8'>8</option>
                        <option value='9'>9</option>
                        <option value='10'>10</option>
                    </select>
                </div>
            </div>
        </form>
        ";
            }
        }

        // Display customization options for Jellycat
        if ($typeOfToy == 'jelly') {
            echo "<h2 style='font-family: pacifico; font-size: 30px;'>Customize your toy</h2>";
            echo "<hr style='width:100%;'/>";

            if ($item['totalQty'] > 0) {
                echo "
                <div style='justify-content: center; padding:10px;background-color:#ECC182; height:auto; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                    width: auto; margin:30px auto; border-radius: 12px;'>
                    <h2 style='padding:20px; font-family: monospace;'>Select size</h2>

                    <form action='add_to_cart_jelly.php' method='POST'>
                        <input type='hidden' name='item_id' value='" . $item['id'] . "'>
                        <input type='hidden' name='price' value='" . $item['price'] . "'>
                        <input type='hidden' name='user_email' value='" . $_COOKIE['user_email'] . "'>

                        <div class='radio-group'>
                            <input type='radio' id='small' name='size' value='small' required>
                            <label class='radio-label' for='small'>small</label>

                            <input type='radio' id='medium' name='size' value='medium' required>
                            <label class='radio-label' for='medium'>medium</label>

                            <input type='radio' id='large' name='size' value='large' required>
                            <label class='radio-label' for='large'>large</label>
                        </div>

                        <h2 style='font-family: monospace;'>Select embroidery</h2>
                        <div class='radio-group'>
                            <input type='radio' id='withoutemb' name='embroid' value='withoutemb' required onclick='toggleEmbroidery(false)'>
                            <label class='radio-label' for='withoutemb'>without embroidery</label>

                            <input type='radio' id='withemb' name='embroid' value='withemb' required onclick='toggleEmbroidery(true)'>
                            <label class='radio-label' for='withemb'>with embroidery</label>
                        </div>

                        <div id='embroidery-options' class='dropdown-container' style='display: none;'>
                            <div class='custom-dropdown'>
                                <select name='color'>
                                    <option selected disabled>Select thread color</option>
                                    <option value='Bubblegum'>Bubblegum</option>
                                    <option value='DustyBlue'>Dusty Blue</option>
                                    <option value='Lavender'>Lavender</option>
                                    <option value='Moss'>Moss</option>
                                    <option value='Pearl'>Pearl</option>
                                </select>
                            </div>
                            <div class='custom-dropdown'>
                                <select name='font'>
                                    <option selected disabled>Select font style</option>
                                    <option value='Chancery'>Chancery</option>
                                    <option value='Hobo'>Hobo</option>
                                    <option value='ScriptMT'>Script MT</option>
                                </select>
                            </div>
                        </div>

                        <div class='cart-container'>
                            <button type='submit' class='cart-button'>Add To Cart</button>
                            <div class='quantity-dropdown'>
                                <select name='quantity' required>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                    <option value='5'>5</option>
                                    <option value='6'>6</option>
                                    <option value='7'>7</option>
                                    <option value='8'>8</option>
                                    <option value='9'>9</option>
                                    <option value='10'>10</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                ";
            } else {
                echo "<p style='font-size: 30px; font-family: monospace; font-weight: bold;'> Item is out of stock! </p>";
            }
        }

        // Similar items section
        echo "<hr/>";
        echo "<h1 style='font-size: 30px; font-family: pacifico;'>Similar Items</h1>";
        echo "<div style='display:flex;justify-content:center;'>";

        // Fetch similar items from the same typeOfToy, excluding the current item
        $sql2 = "SELECT * FROM items WHERE typeOfToy='$typeOfToy' AND id != '$itemId' ORDER BY RAND() LIMIT 4";
        $result2 = $conn->query($sql2);

        if ($result2->num_rows > 0) {
            while ($item2 = $result2->fetch_assoc()) {
                echo "<a style='text-decoration:none; color:black; font-family:monospace; font-size: 15px;' href='http://localhost/stardust/stardust/product-page.php?id=" . $item2["id"]. "&typeoftoy=" . $item2["typeoftoy"]. "'>";
                echo "<div style='text-align:center;margin: 10px;'>"; // Container for each item (image and text)

                // Image
                echo '<img style="padding:30px;margin-bottom:10px;border-radius: 10%; border:5px solid ' . $titleColor . '; height: 200px;" src="assets/' . $item2["img"] . '" alt="' . $item2["title"] . '">';

                // Title and Price Container
                echo "<div style='display:flex; justify-content:space-between; width: 100%; margin-top:5px;'>";

                // Title
                echo "<p style='margin-right:10px;font-weight: bold;'>" . $item2['title'] . "</p>";

                // Price
                echo "<p style='font-weight: bold;'>RM " . $item2['price'] . "</p>";

                echo "</div>";
                echo "</div>";
                echo "<a>";
            }
        } else {
            echo "<p>No similar items available.</p>";
        }

        echo "</div>";
    } else {
        echo "Item not found.";
    }

    $conn->close();
} else {
    echo "Invalid parameters provided.";
}
?>
<script>
    function toggleEmbroidery(showEmbroideryOptions) {
        const embroideryOptions = document.getElementById("embroidery-options");
        embroideryOptions.style.display = showEmbroideryOptions ? "flex" : "none";
    }


    let originalMainImageSrc = document.getElementById("mainImage").src;

    function changeMainImage(imageSrc) {
        const mainImage = document.getElementById("mainImage");

        if (mainImage.src === imageSrc) {
            mainImage.src = originalMainImageSrc;
        } else {
            mainImage.src = imageSrc;
        }
    }

    document.getElementById("mainImage").addEventListener("click", function() {
        this.src = originalMainImageSrc;
    });
</script>

</html>