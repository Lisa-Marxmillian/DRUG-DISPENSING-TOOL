<?php
// subscribe_api_product.php

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the request
    $username = $_POST['username'];
    $productType = $_POST['productType'];

    // Perform the subscription logic and update the database
    require_once("../dbconnect.php"); // Adjust the path based on your file structure

    // Check if the user exists in the apiuser table
    $checkUserSql = "SELECT * FROM apiuser WHERE Username = ?";
    $checkUserStmt = $conn->prepare($checkUserSql);

    if ($checkUserStmt) {
        $checkUserStmt->bind_param("s", $username);
        $checkUserStmt->execute();
        $result = $checkUserStmt->get_result();

        if ($result->num_rows > 0) {
            // User found, update the productType
            $updateProductSql = "UPDATE apiuser SET ProductType = ? WHERE Username = ?";
            $updateProductStmt = $conn->prepare($updateProductSql);

            if ($updateProductStmt) {
                $updateProductStmt->bind_param("ss", $productType, $username);

                // Check for errors after binding parameters
                if ($updateProductStmt->execute()) {
                    echo "Subscription successful.";
                } else {
                    echo "Error updating product type: " . $updateProductStmt->error;
                }

                $updateProductStmt->close();
            } else {
                echo "Error preparing update statement: " . $conn->error;
            }
        } else {
            echo "Subscription Registered successfully";
        }

        // Check for errors after executing the statement
        if ($checkUserStmt->error) {
            echo "Error executing check user statement: " . $checkUserStmt->error;
        }

        $checkUserStmt->close();
    } else {
        echo "Error preparing check user statement: " . $conn->error;
    }

    $conn->close();
} else {
    // Handle non-POST requests
    echo "Invalid request method.";
}
?>
