<?php
session_start(); 
require_once("dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = $_POST['quantity'];
    $TradeName = $_POST['TradeName'];
    $manufacturer = $_POST['manufacturer'];
    $price = $_POST['price'];

    $sql = "UPDATE drug SET quantity = ?, Manufacturer = ?, Price = ? WHERE TradeName = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "isss", $quantity, $manufacturer, $price, $TradeName);
        if (mysqli_stmt_execute($stmt)) {
            echo "Drug updated successfully.";
        } else {
            echo "Error updating drug: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Page</title>
  <link rel="stylesheet" type="text/css" href="drugmodify.css">
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .teal-btn {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px;
      cursor: pointer;
      width: 200px;
    }

    .teal-input {
      width: 200px;
      padding: 5px;
      border: 1px solid #4CAF50;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    .form-container {
      margin-top: 20px;
    }
  </style>
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

  
</head>
<body>
  <form method="POST" action="edit(drug).php">
    <div class="form-container">
      <label for="TradeName">Trade Name:</label>
      <input type="text" name="TradeName" required class="teal-input">
    </div>
    <div class="form-container">
      <label for="quantity">Quantity:</label>
      <input type="text" name="quantity" required class="teal-input">
    </div>
    
    <div class="form-container">
      <label for="manufacturer">Manufacturer:</label>
      <input type="text" name="manufacturer" required class="teal-input">
    </div>
    <div class="form-container">
      <label for="price">Price:</label>
      <input type="text" name="price" required class="teal-input">
    </div>
    <div class="form-container">
      <button type="submit" class="teal-btn">Update Drug</button>
    </div>
    <div class="form-container">
      <button type="reset" class="teal-btn">Reset</button>
    </div>
  </form>
</body>
</html>