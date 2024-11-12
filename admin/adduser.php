<?php
session_start();
require_once("../dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'adduser_btn' is set in the $_POST array
    if (isset($_POST['adduser_btn'])) {
        // 'adduser_btn' is set, proceed with adding a new user
        $usertype = $_POST['usertype'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Define arrays for user-specific fields and corresponding SQL statements
        $userFields = array();
        $userSql = '';

        switch ($usertype) {
            case 'Admin':
                $userFields = array('first_name', 'last_name');
                $userSql = "INSERT INTO admin (username, email, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)";
                break;
            case 'Doctor':
                $userFields = array('first_name', 'last_name', 'phone_number', 'specialization', 'yrsexperience');
                $userSql = "INSERT INTO doctor (username, email, password, first_name, last_name, phone_number, specialization, yrsexperience) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                break;
            case 'Patient':
                $userFields = array('first_name', 'last_name', 'Address', 'phoneno', 'BirthDate');
                $userSql = "INSERT INTO patient (username, email, password, first_name, last_name, Address, phoneno, BirthDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                break;
            case 'Pharmacist':
                $userFields = array('first_name', 'last_name', 'phone_number', 'license_number');
                $userSql = "INSERT INTO pharmacist (username, email, password, first_name, last_name, phone_number, license_number) VALUES (?, ?, ?, ?, ?, ?, ?)";
                break;
        }

        // Make sure $userSql is not empty before preparing the statement
        if (!empty($userSql)) {
            $userStmt = mysqli_prepare($conn, $userSql);

            if ($userStmt) {
                // Prepare an array of parameters to bind based on the userFields array
                $params = array_merge([$username, $email, $password], array_map(function ($field) {
                    return $_POST[$field];
                }, $userFields));

                // Dynamically bind parameters based on the userFields array
                mysqli_stmt_bind_param($userStmt, str_repeat('s', count($params)), ...$params);

                if (mysqli_stmt_execute($userStmt)) {
                    echo "User added successfully.";
                } else {
                    echo "Error adding user: " . mysqli_stmt_error($userStmt);
                }

                mysqli_stmt_close($userStmt);
            } else {
                echo "Error preparing statement: " . mysqli_error($conn);
            }
        } else {
            echo "Error: Insert SQL is empty.";
        }
    }
}
?>

<?php 
$pageTitle = "Add User";
include ('adminheader.php');
?>

<body>
    <h2>Add User</h2>
    <form method="POST" action="">
        <!-- Dropdown list for selecting the user type -->
        <div class="form-group">
            <label for="usertype">Select User Type:</label>
            <select name="usertype" id="usertype" onchange="toggleFields()">
                <option value="Admin">Admin</option>
                <option value="Doctor">Doctor</option>
                <option value="Patient">Patient</option>
                <option value="Pharmacist">Pharmacist</option>
            </select>
        </div>

        <!-- Common fields -->
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" required>
        </div>

        <!-- Dynamic fields based on the selected user type -->
        <div class="admin-fields">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name">
            </div>
        </div>

        <div class="doctor-fields">
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number">
            </div>
            <div class="form-group">
                <label for="specialization">Specialization:</label>
                <input type="text" name="specialization">
            </div>
            <div class="form-group">
                <label for="yrsexperience">Years of Experience:</label>
                <input type="text" name="yrsexperience">
            </div>
        </div>

        <div class="patient-fields">
            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" name="Address">
            </div>
            <div class="form-group">
                <label for="phoneno">Phone Number:</label>
                <input type="text" name="phoneno">
            </div>
            <div class="form-group">
                <label for="BirthDate">Birth Date:</label>
                <input type="text" name="BirthDate">
            </div>
        </div>

        <div class="pharmacist-fields">
            <div class="form-group">
                <label for="license_number">License Number:</label>
                <input type="text" name="license_number">
            </div>
        </div>

        <div class="form-group">
            <button type="submit" name="adduser_btn">Add User</button>
        </div>
    </form>

    <script>
        function toggleFields() {
            var usertype = document.getElementById("usertype").value;
            var adminFields = document.querySelector(".admin-fields");
            var doctorFields = document.querySelector(".doctor-fields");
            var patientFields = document.querySelector(".patient-fields");
            var pharmacistFields = document.querySelector(".pharmacist-fields");

            adminFields.style.display = (usertype === "Admin") ? "block" : "none";
            doctorFields.style.display = (usertype === "Doctor") ? "block" : "none";
            patientFields.style.display = (usertype === "Patient") ? "block" : "none";
            pharmacistFields.style.display = (usertype === "Pharmacist") ? "block" : "none";
        }
    </script>

</body>
<?php include "../PharmaCare Homepage/footer.php" ?>
</html>
