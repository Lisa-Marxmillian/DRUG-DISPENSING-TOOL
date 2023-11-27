<?php
session_start();
 include("patientheader.php");
?>



<html lang="en">
<body>
   

  <main>
     
        <form class="search-form" action="product.php" method="post">
            <input type="text" name="search_query" placeholder="Search for a specific drug...">
            <button type="submit">Search</button>
        </form>
        <form action="" method="post">
            <label for="sortOption">Sort by:</label>
            <select name="sortOption" id="sortOption">
                <option value="all">All</option>
                <option value="price">Price</option>
                <option value="category">Category</option>
            </select>
            <button type="submit" name="sort_btn">Sort</button>
        </form>
        <!-- Start of the product-grid container -->
        <div class="product-grid sorted">
            <?php
            require_once("../dbconnect.php");

            $search_query = "";
            $sql = "";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['search_query'])) {
                    $search_query = $_POST['search_query'];
                    $sql = "SELECT * FROM drug WHERE TradeName LIKE '%$search_query%'";
                }
            } else {
                $sql = "SELECT * FROM drug";
            }

            // Execute the query only if $sql is not empty
            if (!empty($sql)) {
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($drug = mysqli_fetch_assoc($result)) {
                        // Display each drug's information within a product-card
                        echo '<div class="product-card">';
                        echo '<h2>' . $drug['TradeName'] . '</h2>';
                        echo '<img src="../graphics/' . $drug['imagepath'] . '" alt="' . $drug['TradeName'] . '" />';
                        echo '<p>Price: KES ' . $drug['price'] . '</p>';
                        echo '<a class="view-details-btn" href="drugdetails.php?TradeName=' . $drug['TradeName'] . '">View Details</a>';

                        echo '</div>';
                    }
                } else {
                    echo 'No drugs found.';
                }
            }
            ?>
        </div> <!-- End of the product-grid container -->
    </main>
</body>
</html>

<?php
include("../dbconnect.php");

if (isset($_POST['sort_btn'])) {
  $sortOption = $_POST['sortOption'];
  $orderBy = '';

  if ($sortOption === 'price') {
    $orderBy = 'ORDER BY price';

  } elseif ($sortOption === 'category') {
    // Fetch drugs ordered by category
    $orderBy = 'ORDER BY category, TradeName';
  }

  // Fetch drugs from the database with optional sorting
  $sortSql = "SELECT * FROM drug $orderBy";
  // Execute the query and retrieve drug data
  $result = mysqli_query($conn, $sortSql);

  if ($result) {
    $currentCategory = null;

    // Display the sorted or unsorted drugs in grids with category headers
    while ($row = mysqli_fetch_assoc($result)) {
      if ($sortOption === 'category' && $currentCategory !== $row['category']) {
        // Display category header
        echo '<h2 class="category-header">' . $row['category'] . '</h2>';
  
        $currentCategory = $row['category'];
      }

      // Display each drug's image using an <img> tag
      echo '<div class="product-card sorted">';
      echo '<h2>' . $row['TradeName'] . '</h2>';
      echo '<img src="../graphics/' . $row['imagepath'] . '" alt="' . $row['TradeName'] . '" />';
      echo '<p>Price: KES ' . $row['price'] . '</p>';
      echo '<a href="drugdetails.php?TradeName=' . $row['TradeName'] . '">View Details</a>';
      echo '</div>';
    }
  } else {
    echo "Error executing query: " . mysqli_error($conn);
  }

}
 include("patientfooter.php");
 ?>

