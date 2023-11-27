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
        <img src="../graphics/0.png" alt="Logo">
      </div>
      <div class="pharmacist-info">
        Welcome, <?php echo $_SESSION['username']; ?>!
      </div>
</div>
    <nav>
        <ul>
            <li><a href="pharmacistpage.php">Patient Prescriptions</a></li>
            <li><a href="dispense.php">Dispense Drugs</a></li>
            <li><a href="dispensehistory.php">Dispensing History</a></li>
            <li><a href="../logout.php">Logout</a></li> 
        </ul>
</header>