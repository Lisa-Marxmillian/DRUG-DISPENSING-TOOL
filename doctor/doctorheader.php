
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
        <img src="../graphics/0.png" alt="Logo">
      </div>
      <div class="doctor-info">
        Welcome, <?php echo $_SESSION['username']; ?>!
      </div>
      </div>
      <nav>
        <ul>
        <li><a href="doctorpage.php">Home</a></li>
          <li><a href="patientdoctorview.php">Patients</a></li>
          <li><a href="prescription.php">Prescriptions</a></li>
          <li><a href="../logout.php">Logout</a></li> 
        </ul>
      </nav>
    </header>