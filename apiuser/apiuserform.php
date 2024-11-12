<?php
require_once("../dbconnect.php");

function generateApiToken($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $pwd = $_POST['pwd'];
    
   
    $username = $_POST['username'];
    
    $confirm_pwd = $_POST['confirm_pwd']; // Added missing field

    // Extract user type from the form
    $userType = $_POST['userType'];

    // Validate password match
    if ($pwd !== $confirm_pwd) {
        $errorMessage = "Passwords do not match.";
    } else {
        // Check if it's an API user
        if ($userType === 'api') {
            // Extract API-specific information
            $apiToken = generateApiToken();
            $accessType = $_POST['accessType'];
            $productType = $_POST['productType'];

            // Insert API user details into the database
            $insertApiUserSql = "INSERT INTO apiuser (Username, Password, ApiToken, ProductType, AccessType)
                VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertApiUserSql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssss", $username, $pwd, $apiToken, $productType, $accessType);

                if (mysqli_stmt_execute($stmt)) {
                    $successMessage = "API User registered successfully.";
                } else {
                    $errorMessage = "Error inserting API user details: " . mysqli_stmt_error($stmt);
                }

                mysqli_stmt_close($stmt);
            } else {
                $errorMessage = "Error preparing statement: " . mysqli_error($conn);
            }
        } else {
            // Handle registration for regular users
            $sql = "INSERT INTO `patient`(`first_name`, `last_name`, `BirthDate`, `Address`, `password`, `phoneno`, `email`, `username`)
                VALUES('$fname','$lname','$BirthDate','$address','$pwd','$mobile','$email','$username')";

            if ($conn->query($sql) === TRUE) {
                $successMessage = "Account successfully created!";
            } else {
                $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    $conn->close();
}
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
            <a href="../PharmaCare Homepage/drug dispenser.php" class="button">Back to Home</a>
            <a href="../PharmaCare Homepage/login.html" class="button">Login</a>
        </div>
    </div>
</body>

</html>
