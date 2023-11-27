<?php
session_start();

// Include the database connection file
include("../dbconnect.php");

$TradeName = $_GET["TradeName"]; // Assuming you're passing this in the URL

$sql = "SELECT * FROM drug WHERE TradeName = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $TradeName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $drug = mysqli_fetch_assoc($result);

    if ($drug) {
        $pageTitle = $drug['TradeName'];
    } else {
        // Display an error message if the drug TradeName is not found.
        echo "<h1>Drug Not Found</h1>";
        echo "<p>The drug with the TradeName '$TradeName' could not be found.</p>";
    }

    // Close the prepared statement and result set
    mysqli_stmt_close($stmt);
    mysqli_free_result($result);
} else {
    // Display an error message if the query preparation failed.
    echo "<h1>Query Preparation Failed</h1>";
    echo "<p>The query preparation failed with the following error: " . mysqli_error($conn) . "</p>";
}

include 'patientheader.php';
?>
<main>
<div class="section page">
    <div class="wrapper">
        <div class="media-picture">
            <span>
                <img src="../graphics/<?php echo $drug['imagepath']; ?>" alt="<?php echo $pageTitle; ?>" />
            </span>
        </div>

        <div class="media-details">
            <h1><?php echo $pageTitle; ?></h1>
            <table>
                <tr>
                    <th>Category</th>
                    <td><?php echo isset($drug["category"]) ? $drug["category"] : "N/A"; ?></td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>KES <?php echo isset($drug["price"]) ? $drug["price"] : "N/A"; ?></td>
                </tr>
                <tr>
                    <th>Manufacturer</th>
                    <td><?php echo isset($drug["manufacturer"]) ? $drug["manufacturer"] : "N/A"; ?></td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td><?php echo isset($drug["quantity"]) ? $drug["quantity"] : "N/A"; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</main>
<?php include 'patientfooter.php';
?>