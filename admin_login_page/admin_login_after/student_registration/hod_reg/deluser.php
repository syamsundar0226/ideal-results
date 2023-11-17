<?php
include '../../../../connection.php';
// Get the ID of the user to delete
$sno = $_POST['sno'];

// Delete the user from the database
$sql = "DELETE FROM hod_login WHERE sno = $sno";
$result = mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);
?>
