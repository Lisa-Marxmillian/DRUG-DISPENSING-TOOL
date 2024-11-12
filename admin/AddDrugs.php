<?php
session_start(); 
require_once("../dbconnect.php");

$fetchCategoriesSql = "SELECT * FROM drugcategories";
$fetchCategoriesResult = mysqli_query($conn, $fetchCategoriesSql);

if ($fetchCategoriesResult) {
    $categories = mysqli_fetch_all($fetchCategoriesResult, MYSQLI_ASSOC);
} else {
    echo "Error fetching categories: " . mysqli_error($conn);
    $categories = array(); // Set categories to an empty array if an error occurs
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_btn'])) {
        $TradeName = $_POST['tradeName'];
        $Manufacturer = $_POST['manufacturer'];
        $Price = $_POST['price'];
        $Quantity = $_POST['quantity'];

        // Check if the category is empty (nothing selected from dropdown)
        if (empty($_POST['category']) && isset($_POST['new_category'])) {
            $newCategory = $_POST['new_category'];

            // Update drugcategories table
            $addCategorySql = "INSERT INTO drugcategories (category) VALUES (?)";
            $addCategoryStmt = mysqli_prepare($conn, $addCategorySql);

            if ($addCategoryStmt) {
                mysqli_stmt_bind_param($addCategoryStmt, "s", $newCategory);
                mysqli_stmt_execute($addCategoryStmt);
                mysqli_stmt_close($addCategoryStmt);
            } else {
                echo "Error adding category to drugcategories: " . mysqli_error($conn);
            }

            // Set the category to the newly added category
            $Category = $newCategory;
        } else {
            $Category = $_POST['category'];
        }

        // Handle image upload
        if (isset($_FILES['drugimage']) && $_FILES['drugimage']['error'] === UPLOAD_ERR_OK) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = strtolower(pathinfo($_FILES['drugimage']['name'], PATHINFO_EXTENSION));

            if (in_array($fileExtension, $allowedExtensions)) {
                $imagepath = $_FILES['drugimage']['name'];

                $Drugimage = file_get_contents($_FILES['drugimage']['tmp_name']);
                $Drugimage = mysqli_real_escape_string($conn, $Drugimage);
                $Drugimage = base64_encode($Drugimage);

                // Prepare a SQL query to insert drug data into the database
                $addSql = "INSERT INTO drug (TradeName, manufacturer, price, quantity, category, imagepath, drugimage) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $addStmt = mysqli_prepare($conn, $addSql);

                if ($addStmt) {
                    mysqli_stmt_bind_param($addStmt, "sssssss", $TradeName, $Manufacturer, $Price, $Quantity, $Category, $imagepath, $Drugimage);

                    if (mysqli_stmt_execute($addStmt)) {
                        echo "Drug added successfully.";
                    } else {
                        echo "Error adding drug: " . mysqli_error($conn);
                    }

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
    }   elseif (isset($_POST['edit_category_btn'])) {
      // Check if the user selected an existing category to edit
      if (!empty($_POST['selected_category'])) {
          $selectedCategory = $_POST['selected_category'];

          // Display input field to edit the category
          echo '<form action="AddDrugs.php" method="POST">';
          echo '<input type="hidden" name="selected_existing_category" value="' . $selectedCategory . '">';
          echo '<label for="edited_category">Edit Category:</label>';
          echo '<input type="text" name="edited_category" id="edited_category" required>';
          echo '<button type="submit" name="confirm_edit_btn">Confirm Edit</button>';
          echo '</form>';
      } else {
          echo "Please choose an existing category to edit.";
      }
  } elseif (isset($_POST['confirm_edit_btn'])) {
      // Handle the confirmation of editing the category
      $selectedExistingCategory = $_POST['selected_existing_category'];
      $editedCategory = $_POST['edited_category'];

      // Update drugcategories table
      $updateCategorySql = "UPDATE drugcategories SET category = ? WHERE category = ?";
      $updateCategoryStmt = mysqli_prepare($conn, $updateCategorySql);

      if ($updateCategoryStmt) {
          mysqli_stmt_bind_param($updateCategoryStmt, "ss", $editedCategory, $selectedExistingCategory);
          mysqli_stmt_execute($updateCategoryStmt);
          mysqli_stmt_close($updateCategoryStmt);

          // Update drug table with the edited category
          $updateDrugSql = "UPDATE drug SET category = ? WHERE category = ?";
          $updateDrugStmt = mysqli_prepare($conn, $updateDrugSql);

          if ($updateDrugStmt) {
              mysqli_stmt_bind_param($updateDrugStmt, "ss", $editedCategory, $selectedExistingCategory);
              mysqli_stmt_execute($updateDrugStmt);
              mysqli_stmt_close($updateDrugStmt);

              echo "Category updated successfully.";
          } else {
              echo "Error updating drug table: " . mysqli_error($conn);
          }
      } else {
          echo "Error updating drugcategories table: " . mysqli_error($conn);
      }
  }
}

include("adminheader.php");
?>

<div class="add-drug-form">
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

       <!-- Dynamic Category Dropdown -->
<<div class="form-group">
    <label for="category">Category:</label>
    <select name="category" id="category">
        <option value="">Select or Enter Category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['category']; ?>"><?php echo $category['category']; ?></option>
        <?php endforeach; ?>
    </select>
</div>


<div class="form-group">
    <label for="new_category">New Category:</label>
    <input type="text" name="new_category" id="new_category">
</div>


        <!-- Edit Category Button -->
        <div class="form-group">
            <button type="submit" name="edit_category_btn">Edit Category</button>
        </div>
        <div class="form-group">
    <label for="selected_category">Select Category to Edit:</label>
    <select name="selected_category" id="selected_category" required>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['category']; ?>"><?php echo $category['category']; ?></option>
        <?php endforeach; ?>
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
</div>

<?php include("adminfooter.php")?>
