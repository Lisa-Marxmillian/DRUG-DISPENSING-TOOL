<?php
session_start(); 
require_once("../dbconnect.php");

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
<?php 
$pageTitle = "Edit Drug";
include ('adminheader.php');?>

<body>
  
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