<?php
session_start(); 
require_once("../dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_btn'])) {
  // Include the database connection file
  

  $TradeName = $_POST['tradeName'];
  $Manufacturer = $_POST['manufacturer'];
  $Price = $_POST['price'];
  $Quantity = $_POST['quantity'];
  $Category = $_POST['category'];
}
 
  // Handle image upload
  if (isset($_FILES['drugimage']) && $_FILES['drugimage']['error'] === UPLOAD_ERR_OK) {
    // Check if the uploaded file is an image
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($_FILES['drugimage']['name'], PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedExtensions)) {
      // Get the image filename
      $imagepath = $_FILES['drugimage']['name'];

      // Read the uploaded image file
      $Drugimage = file_get_contents($_FILES['drugimage']['tmp_name']);
      $Drugimage = mysqli_real_escape_string($conn, $Drugimage);
      $Drugimage = mysqli_escape_string($conn, $Drugimage);
      $Drugimage = base64_encode($Drugimage);

      // Prepare a SQL query to insert drug data into the database
   // Prepare a SQL query to insert drug data into the database
$addSql = "INSERT INTO drug (TradeName, manufacturer, price, quantity, category, imagepath, drugimage) VALUES (?, ?, ?, ?, ?, ?, ?)";
$addStmt = mysqli_prepare($conn, $addSql);

if ($addStmt) {
    // Bind the parameters
    mysqli_stmt_bind_param($addStmt, "sssssss", $TradeName, $Manufacturer, $Price, $Quantity, $Category, $imagepath, $Drugimage);

    // Execute the statement
    if (mysqli_stmt_execute($addStmt)) {
        echo "Drug added successfully.";
    } else {
        echo "Error adding drug: " . mysqli_error($conn);
    }

    // Close the prepared statement
    mysqli_stmt_close($addStmt);
} else {
    echo "Error preparing statement: " . mysqli_error($conn);
}
    } else {
      echo "Only JPG, JPEG, or PNG files are allowed.";
    }
  } else {
    echo "Error uploading image.";
  }

  // Close the database connection
  mysqli_close($conn);


include("adminheader.php");
?>





  <div class = "add-drug-form">
    <h2>Add Drug</h2>

    <form action="AddDrugs.php" method="POST" enctype="multipart/form-data">

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
  <label for="category">Category:</label>
  <select name="category" id="category" required>
    <option value="Pain Relief">Pain Relief</option>
    <option value="Digestive Care">Digestive Care</option>
    <option value="Eye Care">Eye Care</option>
    <option value="Skin Care">Skin Care</option>
    <option value="Antihistamine">Antihistamine</option>
  </select>
</div>

    <div class="form-group">
  <label for="drugimage">Drug Image:</label>
  <input type="file" name="drugimage" id="drugimage" accept="image/*" required>
</div>
    <div class="form-group">
      <button type="submit" name="add_btn">Add Drug</button>
    </div>
    <div class="form-group">
      <button type="reset">Reset</button>
    </div>
  </form>
  <?php include("adminfooter.php")?>
</html>
