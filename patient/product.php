<?php
session_start();
 include("patientheader.php");
?>



<html lang="en">
<body>
  <header>
    <div class="top-bar">
      <div class="logo">
        <img src="../graphics/0.png" alt="Logo" >
      </div>
      <div class="patient-info">
      Welcome, <?php echo $_SESSION['username']; ?>
      </div>
    </div>
    <nav>
      <ul>
      <li><a href="patientpage.php">Dashboard</a></li> 
        <li><a href="prescriptionpatientview.php">My Prescriptions</a></li> 
        <li><a href="product.php">Medication</a></li> 
        <li><a href="../PharmaCare Homepage/contact.html">Contact Us</a></li>
        <li><a href="../logout.php">Logout</a></li> 
        <li>
          <form class="search-form" action="product.php" method="post"> 
            <input type="text" name="search_query" placeholder="Search..."> 
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

            if (!empty($sql)) {
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($drug = mysqli_fetch_assoc($result)) {
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
        </div>
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
    $orderBy = 'ORDER BY category, TradeName';
  }

  $sortSql = "SELECT * FROM drug $orderBy";
  $result = mysqli_query($conn, $sortSql);

  if ($result) {
    $currentCategory = null;

    while ($row = mysqli_fetch_assoc($result)) {
      if ($sortOption === 'category' && $currentCategory !== $row['category']) {
        echo '<h2 class="category-header">' . $row['category'] . '</h2>';
  
        $currentCategory = $row['category'];
      }

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

