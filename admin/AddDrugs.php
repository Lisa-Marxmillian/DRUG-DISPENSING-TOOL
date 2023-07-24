<?php
require_once("dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tradeName = $_POST['tradeName'];
    $manufacturer = $_POST['manufacturer'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO drugs (TradeName, Manufacturer, price,quantity) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $tradeName, $manufacturer, $price,$quantity);
        if (mysqli_stmt_execute($stmt)) {
            echo "Drug added successfully.";
        } else {
            echo "Error adding drug: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>


<form method="POST" action="add_drug.php">
    <div>
        <label for="tradeName">Trade Name:</label>
        <input type="text" name="tradeName" required>
    </div>
    <div>
        <label for="manufacturer">Manufacturer:</label>
        <input type="text" name="manufacturer" required>
    </div>
    <div>
        <label for="price">Price:</label>
        <input type="text" name="price" required>
    </div>
    <div>
        <label for="quantity">Price:</label>
        <input type="text" name="quantity" required>
    </div>
    <div>
        <button type="submit">Add Drug</button>
    </div>
</form>
