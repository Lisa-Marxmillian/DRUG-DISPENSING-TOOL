<?php
session_start();
require_once("../dbconnect.php");

// Initialize variables
$userDetails = null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'edit_btn' is set in the $_POST array
    if (isset($_POST['edit_btn'])) {
        // 'edit_btn' is set, proceed with fetching user details
        $selectedUsername = $_POST['edit_btn'];

        // Fetch user details based on the selected username and populate the form fields
        $fetchUserSql = "SELECT * FROM (
            SELECT 'Patient' as usertype, patientID as userID, username, email FROM patient
            UNION ALL
            SELECT 'Admin' as usertype, adminID as userID, username, email FROM admin
            UNION ALL
            SELECT 'Doctor' as usertype, doctorID as userID, username, email FROM doctor
            UNION ALL
            SELECT 'Pharmacist' as usertype, pharmaID as userID, username, email FROM pharmacist
        ) AS users
        WHERE username = ?";
        $stmt = mysqli_prepare($conn, $fetchUserSql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $selectedUsername);
            mysqli_stmt_execute($stmt);
            $userDetails = mysqli_stmt_get_result($stmt)->fetch_assoc();
        } else {
            echo "Error preparing statement: " . mysqli_error($conn);
        }
    }

    // Handle user update logic only if $userDetails is set
    if (isset($_POST['update_btn']) && isset($userDetails)) {
        // Update the user in the appropriate table based on the usertype
        switch ($userDetails['usertype']) {
            case 'Patient':
                // Handle patient update logic here
                break;
            case 'Admin':
                // Handle admin update logic here
                break;
            case 'Doctor':
                // Handle doctor update logic here
                break;
            case 'Pharmacist':
                // Handle pharmacist update logic here
                break;
        }
        // You'll need to implement the specific update logic for each user type
        // You can use $userDetails['userID'] to identify the user in the database
    }
}
?>

<?php
$pageTitle = "Edit User";
include('adminheader.php');
?>

<body>

    <h2>Edit User</h2>
    <form method="POST" action="">
        <!-- Dropdown list for selecting the user -->
        <div class="form-group">
            <label for="edit_btn">Select User:</label>
            <select name="edit_btn" id="edit_btn" onchange="this.form.submit()">
                <option value="">Select User</option>
                <?php
                // Fetch usernames from all tables
                $usernames = array();
                $userTables = array('patient', 'admin', 'doctor', 'pharmacist');
                foreach ($userTables as $table) {
                    $fetchUsernamesSql = "SELECT username FROM $table";
                    $result = mysqli_query($conn, $fetchUsernamesSql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $usernames[] = $row['username'];
                    }
                }

                // Display usernames in the dropdown list
                foreach ($usernames as $username) {
                    echo "<option value=\"$username\">$username</option>";
                }
                ?>
            </select>
        </div>

        <!-- Populate form fields with user details -->
        <?php if (isset($userDetails)) { ?>
            <input type="hidden" name="username" value="<?php echo $userDetails['username']; ?>">
            <div class="form-group">
                <label for="usertype">User Type:</label>
                <input type="text" name="usertype" value="<?php echo $userDetails['usertype']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo $userDetails['username']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" value="<?php echo $userDetails['email']; ?>" required>
            </div>

            <!-- Additional fields based on user type -->
          <?php  switch ($userDetails['usertype']) {
    case 'Admin':
        $additionalFieldsSql = "SELECT first_name, last_name FROM admin WHERE username = ?";
        break;
    case 'Doctor':
        $additionalFieldsSql = "SELECT first_name, last_name, phone_number, specialization, yrsexperience FROM doctor WHERE username = ?";
        break;
    case 'Patient':
        $additionalFieldsSql = "SELECT first_name, last_name, address, phoneno, birthdate FROM patient WHERE username = ?";
        break;
    case 'Pharmacist':
        $additionalFieldsSql = "SELECT first_name, last_name, phone_number, license_number FROM pharmacist WHERE username = ?";
        break;
}

if (isset($additionalFieldsSql)) {
    $additionalFieldsStmt = mysqli_prepare($conn, $additionalFieldsSql);

    if ($additionalFieldsStmt) {
        mysqli_stmt_bind_param($additionalFieldsStmt, "s", $selectedUsername);
        mysqli_stmt_execute($additionalFieldsStmt);
        $additionalFieldsResult = mysqli_stmt_get_result($additionalFieldsStmt);
        $additionalFields = mysqli_fetch_assoc($additionalFieldsResult);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    mysqli_stmt_close($additionalFieldsStmt);

    // Echo the additional fields
    foreach ($additionalFields as $key => $value) {
        echo "<div class='form-group'>";
        echo "<label for='{$key}'>{$key}:</label>";
        echo "<input type='text' name='{$key}' value='{$value}'>";
        echo "</div>";
    }
}
?>
            
            <div class="form-group">
                <button type="submit" name="update_btn">Update User</button>
            </div>
        <?php } ?>
    </form>

</body>
<?php include "../PharmaCare Homepage/footer.php" ?>
</html>
