<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect('localhost', 'root', '', 'ddw');

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $birthdate = $_POST['birthdate'];
    $password = $_POST['password'];

    $userType = $_POST['userType'];

    if ($userType === 'patient') {
        $sql = "UPDATE patient SET FirstName='$firstName', LastName='$lastName', Address='$address', BirthDate='$birthdate', password='$password' WHERE ID='$id'";
    } elseif ($userType === 'doctor') {
        $sql = "UPDATE doctor SET FirstName='$firstName', LastName='$lastName', Address='$address', BirthDate='$birthdate', password='$password' WHERE ID='$id'";
    } elseif ($userType === 'pharmacist') {
        $sql = "UPDATE pharmacist SET FirstName='$firstName', LastName='$lastName', Address='$address', BirthDate='$birthdate', password='$password' WHERE ID='$id'";
    } elseif ($userType === 'admin') {
        $sql = "UPDATE admin SET FirstName='$firstName', LastName='$lastName', Address='$address', BirthDate='$birthdate', password='$password' WHERE ID='$id'";
    } else {
        die("Invalid user type.");
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "User data updated successfully.";
    } else {
        echo "Error updating user data: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    if (!isset($_GET['id'])) {
        die("User ID not provided.");
    }

    $userType = $_GET['userType'];

    $conn = mysqli_connect('localhost', 'root', '', 'drugdespensingwebsite');

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id = $_GET['id'];

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

    $sql = "SELECT * FROM $table WHERE ID='$id'";
    $result = mysqli_query($conn, $sql);

    if (!$result || mysqli_num_rows($result) == 0) {
        die("User not found.");
    }

    $row = mysqli_fetch_assoc($result);

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST" action="edit.php">
        <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
        <input type="hidden" name="userType" value="<?php echo $userType; ?>">
        <label>First Name:</label>
        <input type="text" name="firstName" value="<?php echo $row['FirstName']; ?>"><br><br>
        <label>Last Name:</label>
        <input type="text" name="lastName" value="<?php echo $row['LastName']; ?>"><br><br>
        <label>Address:</label>
        <input type="text" name="address" value="<?php echo $row['Address']; ?>"><br><br>
        <label>Birthdate:</label>
        <input type="date" name="birthdate" value="<?php echo $row['BirthDate']; ?>"><br><br>
        <label>Password:</label>
        <input type="password" name="password" value="<?php echo $row['password']; ?>"><br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
