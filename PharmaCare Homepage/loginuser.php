<?php
session_start();
require_once("dbconnect.php");

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

        if ($loginType == 'patient') {
            header("Location: patientpage.php");
            exit;
        } elseif ($loginType == 'doctor') {
            header("Location: doctorpage.php");
            exit;
        } elseif ($loginType == 'pharmacist') {
            header("Location: pharmacistpage.php");
            exit;
        } elseif ($loginType == 'administrator') {
            header("Location: adminpage.php");
            exit;
        }
    }
}

echo "Invalid username or password.";

$stmt->close();
$conn->close();
?>
