<?php
session_start(); 

$pageTitle = "";
include ('adminheader.php');?>
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
        require_once("../dbconnect.php");

        $sql = "SELECT * FROM drug";
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
          die("Query execution failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['TradeName']."</td>";
            echo "<td>".$row['manufacturer']."</td>";
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

    <button class="add-drug-button" onclick="window.location.href='AddDrugs.php'">Add Drugs</button>

   
      </div>
  </body>
  
  <?php include "../PharmaCare Homepage/footer.php" ?> 
  
</html>
