<html>
<head>
  <meta charset="UTF-8">
  <title>Patient Page</title>
 
  <link rel="stylesheet" type="text/css" href="patientpage.css"> 
</head>
<body>
<header>
    <div class="top-bar">
      <div class="logo">
        <img src="../graphics/0.png" alt="Logo">
      </div>
      <div class="patient-info">
        Welcome, <?php echo $_SESSION['username']; ?>!
      </div>
    </div>
      <nav>
        <ul>
        <li><a href="patientpage.php">Dashboard</a></li> 
        <li><a href="prescriptionpatientview.php">My Prescriptions</a></li> 
        <li><a href="product.php">Medication</a></li> 
        <li><a href="../PharmaCare Homepage/contact.html">Contact Us</a></li>
        <li><a href="../logout.php">Logout</a></li> 
        
      </ul>
    </nav>
  </header>