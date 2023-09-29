<?php
session_start();
require_once("../dbconnect.php");

// Check if username, password, and loginType are set
$username = $_POST['username'];
$password = $_POST['password'];
$loginType = $_POST['loginType'];

$tableName = '';
if ($loginType == 'patient') {
    $tableName = 'patient';
} elseif ($loginType == 'doctor') {
    $tableName = 'doctor';
} elseif ($loginType == 'pharmacist') {
    $tableName = 'pharmacist';
} elseif ($loginType == 'administrator') {
    $tableName = 'admin';
}

$stmt = $conn->prepare("SELECT * FROM $tableName WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    if ($row['password'] === $password) {
        $_SESSION['username'] = $username;
        $_SESSION['loginType'] = $loginType;

            // Redirect to appropriate page
            switch ($loginType) {
                case 'patient':
                    header("Location: ../patient/patientpage.php");
                    exit;
                case 'doctor':
                    header("Location: ../doctor/doctorpage.php");
                    exit;
                case 'pharmacist':
                    header("Location: ../pharmacist/pharmacistpage.php");
                    exit;
                case 'administrator':
                    header("Location: ../admin/adminpage.php");
                    exit;
            }
        } else {
            $_SESSION['login_error_message'] = "Incorrect password.";
            header("Location: error.php");
            exit;
        }
    } else {
        $_SESSION['login_error_message'] = "User not found.";
        header("Location: error.php");
        exit;
    }

    $stmt->close();
    $conn->close();

?>


