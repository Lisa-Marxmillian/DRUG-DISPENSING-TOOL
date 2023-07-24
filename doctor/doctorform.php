<?php
require_once("dbconnect.php");

$fname=$_POST['fname'];
$lname= $_POST['lname'];
$pwd=$_POST['pwd'];
$yrsexp= $_POST['yrsexperience'];
$specialization= $_POST['specialization'];
$username=$_POST['username'];
$mobile=$_POST['mobile'];
$email=$_POST['email'];
$pwd=$_POST['pwd'];

$sql = "INSERT INTO `doctor`(`first_name`, `last_name`, `specialization`, `yrsexperience`, `password`, `phone_number`, `email`, `username`)
VALUES('$fname','$lname','$specialization','$yrsexp','$pwd','$mobile','$email','$username')";
if ($conn->query($sql) === TRUE) {
    $successMessage = "Account successfully created!";
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
      <a href="drug dispenser.html" class="button">Back to Home</a>
      <a href="login.html" class="button">Login</a>
    </div>
  </div>
</body>
</html>