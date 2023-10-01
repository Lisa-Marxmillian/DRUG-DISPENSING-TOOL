<?php
session_start(); 

require_once("../dbconnect.php");
$username = $_SESSION['username'];

$sql = "SELECT * FROM appointments WHERE DoctorID = '$username'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Doctor Page</title>
  <link rel="stylesheet" type="text/css" href="doctorpage.css">
</head>
<body>
  <header>
    <div class="top-bar">
      <div class="logo">
        <img src="0.png" alt="Logo">
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

  <section class="appointments-section">
    <h2>Appointments</h2>
    <table>
      <thead>
        <tr>
          <th>Appointment ID</th>
          <th>Patient Name</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['AppID'] . "</td>";
          echo "<td>" . $row['patient_name'] . "</td>";
          echo "<td>" . $row['appointment_date'] . "</td>";
          echo "<td>" . $row['appointment_time'] . "</td>";
          echo "<td>" . $row['status'] . "<td>";
          echo "<td>" . $row['status'] . "</td>";
          echo "<td><a href='updatestatus.php?appointment_id=" . $row['appointment_id'] . "'>Update</a></td>";   
          echo "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
   

  </div>
  </section>

  <?php include "footer.php" ?>
</body>
</html>
