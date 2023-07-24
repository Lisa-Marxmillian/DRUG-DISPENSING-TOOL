<?php
session_start(); 

require_once("dbconnect.php");

$sql = "SELECT * FROM prescription";
$result = mysqli_query($conn, $sql);
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
</header>

    <section class="prescription-list">
        <h2>All Prescriptions</h2>
        <table>
            <thead>
                <tr>
                    <th>Prescription ID</th>
                    <th>Patient Name</th>
                    <th>Medication</th>
                     <th>Frequency</th>
                     <th>Dosage</th>
                    <th>Quantity</th>
                    <th>Date Prescribed</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['PrescriptionID'] . "</td>";
                    echo "<td>" . $row['patientname'] . "</td>";
                    echo "<td>" . $row['TradeName'] . "</td>";
                    echo "<td>" . $row['frequency'] . "</td>";
                    echo "<td>" . $row['dosage'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . $row['date_prescribed'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <footer>
    </footer>
</body>
</html>
