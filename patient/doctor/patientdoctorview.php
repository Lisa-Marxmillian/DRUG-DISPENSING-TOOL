<?php
session_start(); 
require_once("dbconnect.php");
$username = $_SESSION['username']; 
$resultsPerPage =3; 
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1; 
$startFrom = ($currentpage - 1) * $resultsPerPage; 

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM patient WHERE first_name LIKE '%$searchTerm%' OR last_name LIKE '%$searchTerm%' LIMIT $startFrom, $resultsPerPage";
$result = mysqli_query($conn, $sql);

$totalResults = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM patient WHERE first_name LIKE '%$searchTerm%' OR last_name LIKE '%$searchTerm%'"));

$totalPages = ceil($totalResults / $resultsPerPage);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Doctor Page</title>
  <link rel="stylesheet" type="text/css" href="patientdoctorview.css">
</head>
<body>
  <header>
    <div class="top-bar">
      <div class="logo">
        <img src="logo.png" alt="Logo">
      </div>
      <div class="doctor-info">
        Welcome, <?php echo $_SESSION['username']; ?>!
      </div>
      <nav>
        <ul>
        <li><a href="doctorpage.php">Home</a></li>
          <li><a href="patientdoctorview.php">Patients</a></li>
          <li><a href="prescription.php">Prescriptions</a></li>
          <li><a href="logout.php">Logout</a></li> 
        </ul>
      </nav>
    </div>
  </header>
  <body>
    <main>
    <h1>Patients</h1>
    <form action="" method="GET" class="search-form">
      <input type="text" name="search" placeholder="Search by Name" value="<?php echo $searchTerm; ?>">
      <button type="submit">Search</button>
    </form>
    <table id="Table">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Address</th>
          <th>Age</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['first_name']."</td>";
            echo "<td>".$row['last_name']."</td>";
            echo "<td>".$row['Address']."</td>";
            echo "<td>".$row['age']."</td>";
            echo "<td><a class='edit-btn' href='edit.php?id=".$row['PatientID']."'>Edit</a></td>";
            echo "<td><a class='delete-btn' href='?delete=".$row['PatientID']."'>Delete</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='6'>No records found</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <div class="pagination">
      <?php
      for ($page = 1; $page <= $totalPages; $page++) {
        echo "<a href='?search=$searchTerm&page=$page'>$page</a>";
      }
      ?>
    </div>
    </main>
</body>
</html>
