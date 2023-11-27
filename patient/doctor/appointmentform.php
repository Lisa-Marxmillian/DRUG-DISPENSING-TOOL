<?php
require_once("dbconnect.php");



$appointment_time= $_POST['appointment_time'];
$appointment_date = $_POST['appointment_date'];
$PatientID = $_POST['PatientID'];
$DoctorID= $_POST['DoctorID'];



$sql = "INSERT INTO `appointments` (`DoctorID`, `PatientID`, `appointment_date`, `appointment_time`)
VALUES('$DoctorID','$PatientID','$appointment_date','$appointment_time')";

if ($conn->query($sql) === TRUE) {
    $successMessage = "Appointment successfully created";
} else {
    $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Registration</title>
  <link rel="stylesheet" type="text/css" href="register.css">
</head>
<body>
  <div class="container">
    <?php if (isset($successMessage)) { ?>
      <h1><?php echo $successMessage; ?></h1>
    <?php } elseif (isset($errorMessage)) { ?>
      <h1><?php echo $errorMessage; ?></h1>
    <?php } ?>
    <div class="buttonsafter">
      <a href="doctorpage.php" class="button">Back to appointments</a>
      <label for="appointment_time">Appointment Time:</label>
  <input type="time" name="appointment_time" id="appointment_time" required>
  
  <label for="appointment_date">Appointment Date:</label>
  <input type="date" name="appointment_date" id="appointment_date" required>
  
  <label for="patientID">Patient ID:</label>
  <input type="text" name="patientID" id="patientID" required>
  
  <label for="doctorID">Doctor ID:</label>
  <input type="text" name="doctorID" id="doctorID" required>
  
  <input type="submit" value="Submit">
    </div>
  </div>
</body>
</html>
