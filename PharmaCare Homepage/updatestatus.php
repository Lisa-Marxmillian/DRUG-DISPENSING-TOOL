<?php
require_once("dbconnect.php");

if (isset($_POST['appointment_id']) && isset($_POST['status'])) {
  $appointmentId = $_POST['appointment_id'];
  $newStatus = $_POST['status'];

  $sql = "UPDATE appointments SET status = '$newStatus' WHERE appointment_id = $appointmentId";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    echo "Status updated successfully.";
  } else {
    echo "Error updating status: " . mysqli_error($conn);
  }
} else {
  echo "Invalid request. Please provide the necessary parameters.";
}

mysqli_close($conn);
?>
