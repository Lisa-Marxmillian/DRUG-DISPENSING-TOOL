<?php
session_start(); 

require_once("../dbconnect.php");

$sql = "SELECT * FROM dispense";
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
</nav>
</header>

  <section class="dispense-history-section">
    <h2>Dispense History</h2>
    <?php if (mysqli_num_rows($result) > 0) { ?>
      <table>
        <thead>
          <tr>
          <th>DispenseID</th>
            <th>Prescription ID</th>
            <th>TradeName</th>
            <th>Quantity </th>
            <th>Dispense Date</th>
            <th>Total Amount </th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
            <td><?php echo $row['DispenseID']; ?></td>
              <td><?php echo $row['PrescriptionID']; ?></td>
              <td><?php echo $row['TradeName']; ?></td>
              <td><?php echo $row['quantity']; ?></td>
              <td><?php echo $row['dispense_date']; ?></td>
             
              <td><?php echo $row['totalamount']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else {
      echo "No dispense history found.";
    } ?>
  </section>

  <footer>
  </footer>
</body>
</html>
