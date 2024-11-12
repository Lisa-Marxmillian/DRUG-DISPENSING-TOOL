<?php
session_start();
require_once("../dbconnect.php");

// Handle search and sort logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search_btn'])) {
        $username = $_POST['username'];
        $searchTerm = '%' . $username . '%';
        $searchSql = "SELECT * FROM (
            SELECT 'Patient' as usertype, patientID as userID, username, email FROM patient
            UNION ALL
            SELECT 'Admin' as usertype, adminID as userID, username, email FROM admin
            UNION ALL
            SELECT 'Doctor' as usertype, doctorID as userID, username, email FROM doctor
            UNION ALL
            SELECT 'Pharmacist' as usertype, pharmaID as userID, username, email FROM pharmacist
        ) AS users
        WHERE username LIKE ?";
        $stmt = mysqli_prepare($conn, $searchSql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $searchTerm);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['sort_btn'])) {
        $sortOption = $_POST['sortOption'];
        $sortSql = "SELECT * FROM (
            SELECT 'Patient' as usertype, patientID as userID, username, email FROM patient
            UNION ALL
            SELECT 'Admin' as usertype, adminID as userID, username, email FROM admin
            UNION ALL
            SELECT 'Doctor' as usertype, doctorID as userID, username, email FROM doctor
            UNION ALL
            SELECT 'Pharmacist' as usertype, pharmaID as userID, username, email FROM pharmacist
        ) AS users
        ORDER BY $sortOption"; // Use the selected sort option directly
        $result = mysqli_query($conn, $sortSql);
    }
    if (isset($_POST['edit_btn'])) {
        $editUsername = $_POST['edit_btn'];
       
        header("Location: edituser.php?username=$username");
        exit;
    }
}
?>
<?php 
$pageTitle = "Users";
include ('adminheader.php');
?>

<body>

    <section class="search-users-section">
        <h2>Search Users</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <button type="submit" name="search_btn">Search</button>
            </div>
        </form>
    </section>

    <section class="sort-users-section">
        <h2>Sort Users</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="sortOption">Sort By:</label>
                <select name="sortOption" id="sortOption">
                    <option value="usertype">User Type</option>
                    <option value="username">Username</option>
                    <!-- Add more sort options as needed -->
                </select>
                <button type="submit" name="sort_btn">Sort</button>
            </div>
        </form>
    </section>

    <section class="users-table-section">
        <h2>All Users</h2>
        <?php if (isset($result)) { ?>
            <form method="POST" action="edituser.php"> <!-- Form for submitting the Edit action -->
                <table>
                    <thead>
                        <tr>
                            <th>User Type</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['usertype']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td>
                                <button type="submit" name="edit_btn" value="<?php echo $row['username']; ?>">Edit</button>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
        <?php } ?>


    </section>
    <form method="POST" action="adduser.php">
        <button type="submit" name="adduser">Add user</button> 
    </form>
    <form method="POST" action="admininterface.php">
        <button type="submit" name="Generate Token">Generate token</button> 
    </form>
</body>
<?php include "../PharmaCare Homepage/footer.php" ?>
</html>
