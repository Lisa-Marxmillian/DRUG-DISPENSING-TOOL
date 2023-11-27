<?php
require_once("../dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['TradeName'])) {
    $TradeName = $_GET['TradeName'];

    $sql = "DELETE FROM drug WHERE TradeName = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $TradeName);
        if (mysqli_stmt_execute($stmt)) {
            echo "Drug deleted successfully.";
        } else {
            echo "Error deleting drug: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<form method="GET" action="delete(drug).php">
    <input type="hidden" name="TradeName" value="<?php echo $row['TradeName']; ?>">
    <button type="submit" onclick="return confirm('Are you sure you want to delete this drug?')">Delete</button>
</form>
