<?php
session_start(); 
require_once("dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search_btn'])) {
        $username = $_POST['username'];
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
            $searchTerm = '%' . $username . '%';
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
        ORDER BY usertype, username"; 
        if ($sortOption === 'usertype') {
            $sortSql = "SELECT * FROM (
                SELECT 'Patient' as usertype, patientID as userID, username, email FROM patient
                UNION ALL
                SELECT 'Admin' as usertype, adminID as userID, username, email FROM admin
                UNION ALL
                SELECT 'Doctor' as usertype, doctorID as userID, username, email FROM doctor
                UNION ALL
                SELECT 'Pharmacist' as usertype, pharmaID as userID, username, email FROM pharmacist
            ) AS users
            ORDER BY usertype, username";
        } elseif ($sortOption === 'username') {
            $sortSql = "SELECT * FROM (
                SELECT 'Patient' as usertype, patientID as userID, username, email FROM patient
                UNION ALL
                SELECT 'Admin' as usertype, adminID as userID, username, email FROM admin
                UNION ALL
                SELECT 'Doctor' as usertype, doctorID as userID, username, email FROM doctor
                UNION ALL
                SELECT 'Pharmacist' as usertype, pharmaID as userID, username, email FROM pharmacist
            ) AS users
            ORDER BY username, usertype";
        }

        $result = mysqli_query($conn, $sortSql);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Page</title>
  <link rel="stylesheet" type="text/css" href="allusers.css">
</head>
<body>
  <header>
    <div class="top-bar">
      <div class="logo">
        <img src="0.png" alt="Logo">
      </div>
      <div class="admin-info">
        <h2>Welcome back, <?php echo $_SESSION['username']; ?>!</h2>
      </div>
    </div>
    <nav>
      <ul>
        <li><a href="adminpage.php">Home</a></li>
        <li><a href="drugmodify.php">Products</a></li>
        <li><a href="allusers.php">Users</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
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
                </select>
                <button type="submit" name="sort_btn">Sort</button>
            </div>
        </form>
    </section>

    <section class="users-table-section">
        <h2>All Users</h2>
        <?php if (isset($result)) { ?>
            <table>
                <thead>
                    <tr>
                        <th>User Type</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['usertype']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </section>
                    </body>
    <footer>
    <p>&copy; 2023 Drug Dispensing Website. All rights reserved.</p>
    </footer>
</body>
</html>
