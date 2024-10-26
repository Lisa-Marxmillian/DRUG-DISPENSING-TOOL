<?php
session_start(); 
require_once("dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $patientname = $_POST['patientname'];
  $TradeName = $_POST['TradeName'];
  $dosage = $_POST['dosage'];
  $quantity = $_POST['quantity'];
  $frequency = $_POST['frequency'];
  $date_prescribed = date('Y-m-d'); 


  $patientExistsQuery = "SELECT * FROM patient WHERE username = ?";
  $stmtPatientExists = mysqli_prepare($conn, $patientExistsQuery);
  mysqli_stmt_bind_param($stmtPatientExists, "s", $patientname);
  mysqli_stmt_execute($stmtPatientExists);
  $resultPatientExists = mysqli_stmt_get_result($stmtPatientExists);

  
  $tradeNameExistsQuery = "SELECT * FROM drug WHERE TradeName = ?";
  $stmtTradeNameExists = mysqli_prepare($conn, $tradeNameExistsQuery);
  mysqli_stmt_bind_param($stmtTradeNameExists, "s", $TradeName);
  mysqli_stmt_execute($stmtTradeNameExists);
  $resultTradeNameExists = mysqli_stmt_get_result($stmtTradeNameExists);

  if (mysqli_num_rows($resultPatientExists) > 0 && mysqli_num_rows($resultTradeNameExists) > 0) {
   
    $insertSql = "INSERT INTO prescription (patientname, TradeName, dosage, quantity, frequency, date_prescribed)
                VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertSql);

    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "ssssss", $patientname, $TradeName, $dosage, $quantity, $frequency, $date_prescribed);

      if (mysqli_stmt_execute($stmt)) {
        echo "Prescription added successfully.";
      } else {
        echo "Error adding prescription: " . mysqli_stmt_error($stmt);
      }

      mysqli_stmt_close($stmt);
    } else {
      echo "Error preparing statement: " . mysqli_error($conn);
    }
  } else {
    echo "Patient or medication does not exist.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Prescription</title>
  <link rel="stylesheet" type="text/css" href="prescription.css">
</head>
<body>
  <header>
    <div class="top-bar">
      <div class="logo">
        <img src="logo.png" alt="Logo">
      </div>
      <div class="doctor-info">
        Welcome, <?php echo $_SESSION['username']; ?>!
      </div>
      <nav>
        <ul>
        <li><a href="doctorpage.php">Home</a></li>
          <li><a href="patientdoctorview.php">Patients</a></li>
          <li><a href="prescription.php">Prescriptions</a></li>
          <li><a href="logout.php">Logout</a></li> 
        </ul>
      </nav>
    </div>
    </header>

<section class="prescription-form-section">
  <h2>Prescription Form</h2>
  <form method="POST" action="">
    <div class="form-group">
      <label for="patientname">Patient:</label>
      <select name="patientname" id="patientname" required>
        <option value="" disabled selected>Select Patient</option>
        <?php
        $sql = "SELECT * FROM patient";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value='" . $row['username'] . "'>" . $row['username'] . "</option>";
        }
        ?>
      </select>
    </div>
    <div class="form-group">

<label for="TradeName">Medication:</label>
<select name="TradeName" id="TradeName" required>
  <option value="" disabled selected>Select Medication</option>
  <?php
  $sqlMedication = "SELECT DISTINCT TradeName FROM drug";
  $resultMedication = mysqli_query($conn, $sqlMedication);

  while ($rowMedication = mysqli_fetch_assoc($resultMedication)) {
    echo "<option value='" . $rowMedication['TradeName'] . "'>" . $rowMedication['TradeName'] . "</option>";
  }
  ?>
</select>


        
      </div>
      <div class="form-group">
        <label for="frequency">Frequency:</label>
        <input type="text" name="frequency" id="frequency" required>
      </div>
      <div class="form-group">
       
       

      </div>
      <div class="form-group">
        <label for="dosage">Dosage:</label>
        <input type="text" name="dosage" id="dosage" required>
      </div>
      <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" id="quantity" required>
      </div>
     
      <div class="form-group">
        <button type="submit">Submit</button>
      </div>
    </form>
  </section>
  <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $patientname = $_POST['patientname'];
  $TradeName = $_POST['TradeName'];
  $dosage = $_POST['dosage'];
  $quantity = $_POST['quantity'];
  $frequency = $_POST['frequency'];

  $patientExistsQuery = "SELECT * FROM patient WHERE username = '$patientname'";
  $resultPatientExists = mysqli_query($conn, $patientExistsQuery);

  $tradeNameExistsQuery = "SELECT * FROM drug WHERE TradeName = '$TradeName'";
  $resultTradeNameExists = mysqli_query($conn, $tradeNameExistsQuery);

  if (mysqli_num_rows($resultPatientExists) > 0 && mysqli_num_rows($resultTradeNameExists) > 0) {
    $insertSql = "INSERT INTO prescription (patientname, TradeName, dosage, quantity, frequency, date_prescribed)
                VALUES ($patientname, $TradeName, $dosage, $quantity, $frequency, $date_prescribed)";
    if (mysqli_query($conn, $insertSql)) {
      echo "Prescription added successfully.";
    } else {
      echo "Error adding prescription: " . mysqli_error($conn);
  
}}}?>

  <footer>
  </footer>
</body>
</html>
