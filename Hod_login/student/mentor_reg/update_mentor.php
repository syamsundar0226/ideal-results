<?php
ini_set('memory_limit', '-1');
session_start();
include '../../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Retrieve the selected username and checked Htno values from the form
   $username = $_POST["username"];
   $htnoList = $_POST["htno"];

   // Clear the previously selected Htno values in the session by assigning an empty array
   $_SESSION['selectedHtnos'] = [];

   // Retrieve the previously selected Htno values from the session
   $selectedHtnos = isset($_SESSION['selectedHtnos']) ? $_SESSION['selectedHtnos'] : [];

   // Combine the previously selected Htno values with the newly selected Htno values
   $allHtnos = array_merge($selectedHtnos, $htnoList);

   // Store the combined Htno values in the session
   $_SESSION['selectedHtnos'] = $allHtnos;

   // Update the Mentor column in the student_results table for all the selected Htno values
   foreach ($allHtnos as $htno) {
      $sql = "UPDATE student_results SET Mentor='$username' WHERE Htno='$htno'";
      mysqli_query($conn, $sql);
   }

   // Redirect back to the page
   header("Location: user.php");
   exit();
}

?>
