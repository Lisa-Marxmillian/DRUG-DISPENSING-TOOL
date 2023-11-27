<?php
session_start(); 
?>
<?php 
$pageTitle = "Administrator Page";
include ('adminheader.php');?>
  <main>
  <section class="profile-section">
      <h2>Profile Information</h2>
      <?php
      require_once("../dbconnect.php");

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
     
 <?php include("adminfooter.php")?>
</body>
</html>
