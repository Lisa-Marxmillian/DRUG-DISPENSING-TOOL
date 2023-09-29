<?php
session_start(); 
?>

<html>
<head>
  <meta charset="UTF-8">
  <title>Products</title>
 
  <link rel="stylesheet" type="text/css" href="product.css"> 
</head>
<body>
  <header>
    <div class="top-bar">
      <div class="logo">
        <img src="../graphics/0.png" alt="Logo" >
      </div>
      <div class="patientinfo">
      Welcome, <?php echo $_SESSION['username']; ?>!
      </div>
    </div>
    <nav>
      <ul>
      <li><a href="patientpage.php">Dashboard</a></li> 
        <li><a href="prescriptionpatientview.php">My Prescriptions</a></li> 
        <li><a href="product.php">Medication</a></li> 
        <li><a href="contact.html">Contact Us</a></li>
        <li><a href="logout.php">Logout</a></li> 
        <li>
          <form class="search-form" action="product.php" method="post"> 
            <input type="text" name="search_query" placeholder="Search..."> 
            <button type="submit">Search</button>
          </form>
        </li>
      </ul>
    </nav>
  </header>

  <main>
    <h1>Medication</h1>
    <div class="product-grid">
      <?php
      require_once("../dbconnect.php");

      $search_query = "";
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['search_query'])) {
          $search_query = $_POST['search_query'];
          $sql = "SELECT * FROM drug WHERE TradeName LIKE '%$search_query%' OR price LIKE '%$search_query%'";
        }
      } else {
        $sql = "SELECT * FROM drug";
      }

      $result = mysqli_query($conn, $sql);

      if ($result === false) {
          die("Query execution failed: " . mysqli_error($conn));
      }
      
      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo '<div class="product-card">';
              echo '<h2>' . $row['TradeName'] . '</h2>';
              echo '<img src="' . $row['image_url'] . '" alt="' . $row['TradeName'] . '" />';
              echo '<p>Price: KES ' . $row['price'] . '</p>';
              echo '<button class="view-details-btn">View Details</button>';
              echo '</div>';
          }
      } else {
          echo '<p>No products found.</p>';
      }
      
      mysqli_close($conn);
      ?>
      </div>
      
  </main>

  <footer>
    <div class="footer-column">
      <div class="contact-info">
        <h2>Contact Us</h2>
        <p>123 Kilimani, Nairobi</p>
        <p>Phone: (123) 456-7890</p>
        <p>Email: info@pharmacare.com</p>
      </div>
      <div class="footer-links">
        <a href="termsandconditions.html">Terms and Conditions</a>
        <a href="Events.html">Events</a>
        <a href="privacypolicy.html">Privacy Policy</a>
      </div>
    </div>
    <div class="footer-column">
      <div class="offers">
        <h2>Special Offers</h2>
        <p>Subscribe to our newsletter and get exclusive discounts.</p>
        <a href="#" class="cta-button">Subscribe</a>
      </div>
      <p>&copy; 2023 Drug Dispensing Website. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
