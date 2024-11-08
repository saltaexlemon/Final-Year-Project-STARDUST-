<?php
include("navigation.php");

// Retrieve filter parameters from URL
$category = isset($_GET['category']) ? explode(",", $_GET['category']) : [];
$minPrice = isset($_GET['minPrice']) ? (float)$_GET['minPrice'] : 0;
$maxPrice = isset($_GET['maxPrice']) ? (float)$_GET['maxPrice'] : 5000;

// Database connection
$conn = new mysqli('localhost', 'root', '', 'stardust');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Build the SQL query with optional category and price filtering
$sql = "SELECT * FROM items WHERE price BETWEEN $minPrice AND $maxPrice";
if (!empty($category)) {
    $categories = implode("','", array_map([$conn, 'real_escape_string'], $category));
    $sql .= " AND typeoftoy IN ('$categories')";
}

$result = $conn->query($sql);
?>

<link rel="stylesheet" href="./styles/categories.css">
<h2 class="prod-list-header"> Product List </h2>

<div class="content-wrapper">
    <aside class="filters">
        <h2 class="filters-text">Filters</h2>
        <label><input type="checkbox" class="category-filter" value="jelly"> Jellycat </label><br>
        <label><input type="checkbox" class="category-filter" value="sonny"> Sonny Angels </label><br>
        <label><input type="checkbox" class="category-filter" value="smiski"> Smiski </label><br>
        <hr />

        <h3 class="price-range">Price Filter</h3>
        <span class="range-value" id="priceRangeValue">RM 0 - RM 500</span><br>
        <input type="range" id="minPriceSlider" name="minPrice" min="0" max="500" value="0" step="10">
        <input type="range" id="maxPriceSlider" name="maxPrice" min="0" max="500" value="500" step="10">
        <br><br>
        <button class="apply-btn" id="applyFilters">Apply Filters</button>
    </aside>

    <div class="card-div">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<a class="prod-text" href="product-page.php?id=' . $row["id"] . '&typeoftoy=' . $row["typeoftoy"] . '">';
                echo '<div class="cate-card">';
                echo '  <img class="cate-img" src="assets/' . $row["img"] . '" alt="' . $row["title"] . '">';
                echo '  <div class="cate-title"> <p>' . $row["title"] . ' </p> </div>';
                echo '  <div class="cate-price"> <p> RM' . $row["price"] . ' </p> </div>';
                echo '</div>';
                echo '</a>';
            }
        } else {
            echo "No items available in this category.";
        }
        $conn->close();
        ?>
    </div>
</div>

<script>
    document.getElementById("applyFilters").addEventListener("click", function() {
        const selectedCategories = Array.from(document.querySelectorAll(".category-filter:checked"))
            .map(cb => cb.value);
        const minPrice = document.getElementById("minPriceSlider").value;
        const maxPrice = document.getElementById("maxPriceSlider").value;

        const params = new URLSearchParams();
        if (selectedCategories.length) {
            params.set("category", selectedCategories.join(","));
        }
        params.set("minPrice", minPrice);
        params.set("maxPrice", maxPrice);

        window.location.href = "?" + params.toString();
    });

    // Update price range display
    document.getElementById("minPriceSlider").addEventListener("input", updatePriceRange);
    document.getElementById("maxPriceSlider").addEventListener("input", updatePriceRange);

    function updatePriceRange() {
        const minPrice = document.getElementById("minPriceSlider").value;
        const maxPrice = document.getElementById("maxPriceSlider").value;
        document.getElementById("priceRangeValue").textContent = `RM ${minPrice} - RM ${maxPrice}`;
    }
</script>