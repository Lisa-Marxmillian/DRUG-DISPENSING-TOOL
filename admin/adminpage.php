<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Administrator Page</title>
  <link rel="stylesheet" type="text/css" href="adminpage.css">
</head>
<body>
  <header>
    <div class="top-bar">
      <div class="logo">
        <img src="0.png" alt="Logo">
      </div>
      <div class="admin-info">
        <h2>Welcome back, <?php echo $_SESSION['username']; ?>!</h2>
    </div>
    </div>
    <nav>
      <ul>
        <li><a href="adminpage.php">Home</a></li>
        <li><a href="drugmodify.php">Products</a></li>
        <li><a href="allusers.php">Users</a></li>
        <li><a href="logout.php">Logout</a></li> 
        
      </ul>
    </nav>
  </header>
  <main>
  <section class="profile-section">
      <h2>Profile Information</h2>
      <?php
      require_once("dbconnect.php");

      $username = $_SESSION['username']; 

      $sql = "SELECT * FROM  admin WHERE username = ?";
      $stmt = mysqli_prepare($conn, $sql);

      if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          echo "<p><strong>First Name:</strong> " . $row['first_name'] . "</p>";
          echo "<p><strong>Last Name:</strong> " . $row['last_name'] . "</p>";
          echo "<p><strong>User Name:</strong> " . $row['username'] . "</p>";
          echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
       
         
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
     
  <footer>

  <p>&copy; 2023 PharmaCare Website. All rights reserved.</p>
    </footer>
</body>
</html>
