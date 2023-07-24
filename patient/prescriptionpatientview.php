<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>My Prescriptions</title>
  <link rel="stylesheet" type="text/css" href="patientpage.css">
</head>
<body>
  <header>
    <div class="top-bar">
      <div class="logo">
        <img src="0.png" alt="Logo">
      </div>
      <div class="patient-info">
        Welcome, <?php echo $_SESSION['username']; ?>!
      </div>
      <nav>
        <ul>
        <li><a href="patientpage.php">Dashboard</a></li> 
        <li><a href="prescriptionpatientview.php">My Prescriptions</a></li> 
        <li><a href="product.php">Medication</a></li> 
        <li><a href="contact.html">Contact Us</a></li>
          <li><a href="logout.php">Logout</a></li> 
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <h1>My Prescriptions</h1>
    <div class="prescription-list">
      <?php
      
      require_once("dbconnect.php");

      $Patientname = $_SESSION['username']; 
      $sql = "SELECT * FROM prescription WHERE patientname= ?";
      $stmt = mysqli_prepare($conn, $sql);

      if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $patientname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='prescription-card'>";
            echo "<h2>Patientname: " . $row['Patientname'] . "</h2>";
            echo "<p>Trade Name: " . $row['TradeName'] . "</p>";
            echo "<p>Dosage: " . $row['Dosage'] . "</p>";
            echo "<p>Quantity: " . $row['Quantity'] . "</p>";
            echo "<p>Frequency: " . $row['Frequency'] . "</p>";
            echo "<p>Date Prescribed: " . $row['DatePrescribed'] . "</p>";
            echo "<p>Status: " . $row['Status'] . "</p>";
            echo "</div>";
          }
        } else {
          echo "<p>No prescriptions found.</p>";
        }

        mysqli_stmt_close($stmt);
      } else {
        echo "Error preparing statement: " . mysqli_error($conn);
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
