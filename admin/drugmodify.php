<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Page</title>
  <link rel="stylesheet" type="text/css" href="drugmodify.css">
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
    <h1>DRUG DATA</h1>
    <table id="DrugsTable">
      <thead>
        <tr>
          <th>TradeName</th>
          <th>Manufacturer</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require_once("dbconnect.php");

        $sql = "SELECT * FROM drug";
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
          die("Query execution failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['TradeName']."</td>";
            echo "<td>".$row['Manufacturer']."</td>";
            echo "<td>".$row['price']."</td>";
            echo "<td>".$row['quantity']."</td>";
            echo "<td><a class='edit-btn' href='edit(drug).php?id=".$row['TradeName']."' target='_blank'>Edit</a></td>";
            echo "<td><a class='delete-btn' href='delete(drug).php?id=".$row['TradeName']."' target='_blank'>Delete</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='4'>No records found</td></tr>";
        }

       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          if (isset($_POST['add_btn'])) {
            $TradeName = $_POST['tradeName'];
            $Manufacturer = $_POST['manufacturer'];
            $Price = $_POST['price'];
            $Quantity = $_POST['quantity'];

            $addSql = "INSERT INTO drug (TradeName, manufacturer, price, quantity) VALUES (?, ?, ?, ?)";
            $addStmt = mysqli_prepare($conn, $addSql);

            if ($addStmt) {
              mysqli_stmt_bind_param($addStmt, "ssss", $TradeName, $Manufacturer, $Price, $Quantity);

              if (mysqli_stmt_execute($addStmt)) {
                echo "Drug added successfully.";
              } else {
                echo "Error adding drug: " . mysqli_error($conn);
              }

              mysqli_stmt_close($addStmt);
            } else {
              echo "Error preparing statement: " . mysqli_error($conn);
            }
          }
        }
        ?>
      </tbody>
    </table>

     <div class = "add-drug-form">
    <h2>Add Drug</h2>

   
    <form method="POST" action="">
      <div class="form-group">
        <label for="tradeName">Trade Name:</label>
        <input type="text" name="tradeName" id="tradeName" required>
      </div>
      <div class="form-group">
        <label for="manufacturer">Manufacturer:</label>
        <input type="text" name="manufacturer" id="manufacturer" required>
      </div>
      <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" name="price" id="price" required>
      </div>
      <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" id="quantity" required>
      </div>
      <div class="form-group">
        <button type="submit" name="add_btn">Add Drug</button>
      </div>
      <div class="form-group">
        <button type="reset" >Reset</button>
      </div>
    </form>
      </div>
  </body>
  <footer>

  <p>&copy; 2023 Drug Dispensing Website. All rights reserved.</p>
  </footer>
</html>
