<?php
session_start(); 
?>

<html>
<head>
  <meta charset="UTF-8">
  <title>Patient Dashboard </title>
 
  <link rel="stylesheet" type="text/css" href="patientpage.css"> 
</head>
<body>
  <header>
    <div class="top-bar">
      <div class="logo">
        <img src="../graphics/0.png" alt="Logo" >
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
        <li><a href="contact.html">Contact Us</a></li>
        <li><a href="logout.php">Logout</a></li> 
        <li>
          <form class="search-form">
            <input type="text" placeholder="Search..."> 
            <button type="submit">Search</button>
          </form>
        </li>
      </ul>
    </nav>
    <div class="hero">
      <div class="hero-content">
        <h1>Welcome!</h1> 
        <h2>Healthcare Made Easy</h2>
        <p>
          With just a few clicks, you can conveniently order your prescribed medications
          from the comfort of your home, saving you time and effort. Safely store and
          manage your prescriptions online. Our automatic refill reminders ensure you never
          run out of your essential medications. Rest assured that your sensitive medical
          information is securely protected. Gain access to a wide range of medications,
          including rare and specialized drugs, all at competitive prices. Compare prices,
          read reviews, and make informed choices for your well-being. Experience the
          accessibility, convenience, and cost savings of our user-friendly services.
        </p>
      </div>
      <div class="hero-image">
        <img src="../graphics/2.png" alt="Header Image" style="width: 500px; height: auto;">
      </div>
    </div>
  </header>

  <main>
  <section class="profile-section">
      <h2>Profile Information</h2>
      <?php
      
      require_once("../dbconnect.php");

      $username = $_SESSION['username']; 

      $sql = "SELECT * FROM patient WHERE username = ?";
      $stmt = mysqli_prepare($conn, $sql);

      if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          echo "<p><strong>Full Name:</strong> " . $row['username'] . "</p>";
          echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
          echo "<p><strong>Phone:</strong> " . $row['phoneno'] . "</p>";
          
        } else {
          echo "<p>Profile information not found.</p>";
        }

        mysqli_stmt_close($stmt);
      } else {
        echo "Error preparing statement: " . mysqli_error($conn);
      }

      mysqli_close($conn);
      ?>
    </section>
  </main>

    <?php include "../PharmaCare Homepage/footer.php" ?>  
</body>
</html>
