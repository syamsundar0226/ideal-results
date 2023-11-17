<?php 
// Connect to the database
include '../../../connection.php';

// Get the ID of the user to delete
$sno = $_POST['sno'];

// Get the username of the mentor being deleted
$sql = "SELECT username FROM mentor_login WHERE sno = $sno";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$mentor_username = $row['username'];

// Delete the user from the mentor_login table
$sql = "DELETE FROM mentor_login WHERE sno = $sno";
$result = mysqli_query($conn, $sql);

// Set the mentor column to NULL in the student_results table for the deleted mentor
$sql = "UPDATE student_results SET Mentor = NULL WHERE Mentor = '$mentor_username'";
$result = mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);
?>