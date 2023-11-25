<?php
session_start(); 
?>

<html>
<head>
  <meta charset="UTF-8">
  <title>Patient Dashboard </title>
 
  <link rel="stylesheet" type="text/css" href="patientpage.css"> 
</head>
<body>
<?php include "patientheader.php";?>
  <main>
  <section class="profile-section">
      <h2>Profile Information</h2>
      <?php
      
      require_once("../dbconnect.php");

      $username = $_SESSION['username']; 

      $sql = "SELECT * FROM patient WHERE username = ?";
      $stmt = mysqli_prepare($conn, $sql);

      if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          echo "<p><strong>Full Name:</strong> " . $row['username'] . "</p>";
          echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
          echo "<p><strong>Phone:</strong> " . $row['phoneno'] . "</p>";
          
        } else {
          echo "<p>Profile information not found.</p>";
        }

        mysqli_stmt_close($stmt);
      } else {
        echo "Error preparing statement: " . mysqli_error($conn);
      }

      mysqli_close($conn);
      ?>
    </section>
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
