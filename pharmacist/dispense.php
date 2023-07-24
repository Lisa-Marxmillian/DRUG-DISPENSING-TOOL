<?php
session_start(); 

require_once("dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['search_btn'])) {
    $patientName = $_POST['patientName'];
    $searchSql = "SELECT * FROM prescription WHERE PatientName = ?";
    $stmt = mysqli_prepare($conn, $searchSql);

    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "s", $patientName);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
    } else {
      echo "Error preparing statement: " . mysqli_error($conn);
    }
  }

  if (isset($_POST['dispense_btn'])) {
    $prescriptionID = $_POST['prescriptionID'];
    $updateSql = "UPDATE prescription SET status = 'dispensed' WHERE PrescriptionID = ?";
    $stmt = mysqli_prepare($conn, $updateSql);

    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "i", $prescriptionID);
      if (mysqli_stmt_execute($stmt)) {
        echo "Prescription dispensed successfully.";
      } else {
        echo "Error dispensing prescription: " . mysqli_error($conn);
      }
      mysqli_stmt_close($stmt);
    } else {
      echo "Error preparing statement: " . mysqli_error($conn);
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pharmacist Page</title>
    <link rel="stylesheet" type="text/css" href="pharmacistpage.css">
</head>
<body>
    <header>
    <div class="top-bar">
      <div class="logo">
        <img src="0.png" alt="Logo">
      </div>
      <div class="pharamacist-info">
        Welcome, <?php echo $_SESSION['username']; ?>!
      </div>
      
  
    <nav>
        <ul>
            <li><a href="pharmacistpage.php">Patient Prescriptions</a></li>
            <li><a href="dispense.php">Dispense Drugs</a></li>
            <li><a href="dispensehistory.php">Dispensing History</a></li>
            <li><a href="logout.php">Logout</a></li> 
        </ul>
    </nav>
    </div>
  </header>
>

<section class="search-prescription-section">
    <h2>Search Prescription</h2>
    <form method="POST" action="">
      <div class="form-group">
        <label for="patientName">Patient Name:</label>
        <input type="text" name="patientName" id="patientName" required>
        <button type="submit" name="search_btn">Search</button>
      </div>
    </form>
  </section>

  <section class="dispense-prescription-section">
    <h2>Dispense Prescription</h2>
    <?php if (isset($result)) { ?>
      <form method="POST" action="">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <div class="form-group">
            <label for="prescriptionID">Prescription ID:</label>
            <input type="text" name="prescriptionID" id="prescriptionID" value="<?php echo $row['PrescriptionID']; ?>" required readonly>
          </div>
        <br><br>
          <div class="form-group">
            <label for="tradeName">Trade Name:</label>
            <input type="text" name="tradeName" id="tradeName" value="<?php echo $row['TradeName']; ?>" required readonly>
          </div>
          <br><br>
         

          <div class="form-group">
            <label for="totalamount">Total Amount:</label>
            <input type="text" name="totalamount" id="totalamount" required>
          </div>
          <br><br>
          <div class="form-group">
            <label for="datePrescribed">Date Prescribed:</label>
            <input type="text" name="datePrescribed" id="datePrescribed" value="<?php echo $row['date_prescribed']; ?>" required readonly>
          </div>
          <br><br>
          <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" name="status" id="status" value="<?php echo $row['status']; ?>" required readonly>
          </div>
          
          <div class="form-group">
            <button type="submit" name="dispense_btn">Dispense</button>
          </div>
        <?php } ?>
      </form>
    <?php } elseif (isset($_POST['search_btn'])) {
      echo "No matching prescriptions found.";
    } ?>
  </section>

  <footer>

  </footer>
</body>
</html>