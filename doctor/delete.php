<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect('localhost', 'root', '', 'ddw');

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id = $_POST['id'];
    $userType = $_POST['userType'];

    if ($userType === 'patient') {
        $table = 'patient';
    } elseif ($userType === 'doctor') {
        $table = 'doctor';
    } elseif ($userType === 'pharmacist') {
        $table = 'pharmacist';
    } elseif ($userType === 'admin') {
        $table = 'admin';
    } else {
        die("Invalid user type.");
    }

    $sql = "DELETE FROM $table WHERE ID='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "User record deleted successfully.";
    } else {
        echo "Error deleting user record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    die("Invalid request.");
}
