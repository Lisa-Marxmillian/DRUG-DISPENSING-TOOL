<?php
require_once("../dbconnect.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract user details from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $accessType = $_POST['accessType'];
    $productType = $_POST['productType'];

    // Validate and sanitize user inputs here (not shown in this example)

    // Perform token generation logic
    $apiToken = generateApiToken(); // Implement this function

    // Save API user details to the database (similar to your registration logic)
    saveApiUserDetails($username, $password, $apiToken, $accessType, $productType, $conn);

    // Optionally, you can redirect the admin back to the interface or show a success message
    header("Location: admininterface.php");
    exit();
}

// Implement your token generation logic
function generateApiToken($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
  
    return $randomString;
}

function saveApiUserDetails($username, $password, $apiToken, $accessType, $productType, $conn) {
    $insertApiUserSql = "INSERT INTO apiuser (Username, Password, ApiToken, AccessType, ProductType) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertApiUserSql);

    if ($stmt) {
        $stmt->bind_param("sssss", $username, $password, $apiToken, $accessType, $productType);

        if ($stmt->execute()) {
            echo "API User registered successfully.";
        } else {
            echo "Error inserting API user details: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$conn->close();
?>
