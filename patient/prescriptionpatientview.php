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
  <?php include "patientheader.php";?>

  <main>
    <h1>My Prescriptions</h1>
    <div class="prescription-list">
      <?php
      
      require_once("../dbconnect.php");

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

  <?php include "../PharmaCare Homepage/footer.php" ?>  
</body>
</html>
