<?php
ini_set('memory_limit', '-1');
// Connect to database
session_start();
   include '../../connection.php';
if(isset($_SESSION['branch'])) 
   {
       $branch = $_SESSION['branch'];
   }

// Get batch value from query string
$batch = $_GET['batch'];

// Build SQL query to get branch options based on batch value
$sql = "SELECT DISTINCT Branch FROM student_results WHERE Batch='$batch' AND Branch='$branch' ORDER BY Branch ASC";
$result = mysqli_query($conn, $sql);

// Generate options for branch dropdown menu
$options = "";
while ($row = mysqli_fetch_array($result)) {
    $selected = ($branch == $row['Branch']) ? "selected" : ""; // Check if option is selected
  $options .= "<option value='" . $row['Branch'] . "' $selected>" . $row['Branch'] . "</option>";
}

echo $options;
?>
