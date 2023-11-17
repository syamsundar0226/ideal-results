<?php
// Connect to database
ini_set('memory_limit', '-1');
session_start();
   include '../../connection.php';
if(isset($_SESSION['branch'])) 
   {
       $branch = $_SESSION['branch'];
   }

// Get batch value from query string
$batch = $_GET['batch'];

// Build SQL query to get branch options based on batch value
if(empty($branch)) {
$sql = "SELECT DISTINCT Branch FROM student_results WHERE Batch='$batch'  ORDER BY Branch ASC";
$result = mysqli_query($conn, $sql);
 $options = "<option value='' selected>Branch</option>"; // Add default option
// Generate options for branch dropdown menu

while ($row = mysqli_fetch_array($result)) {
    $options .= "<option value='" . $row['Branch'] . "'>" . $row['Branch'] . "</option>";
}
 } else {
     $sql = "SELECT DISTINCT Branch FROM student_results WHERE Batch='$batch' AND Branch='$branch'  ORDER BY Branch ASC";
     $result = mysqli_query($conn, $sql);
     $options = "";
     while ($row = mysqli_fetch_array($result)) {
   $selected = ($branch == $row['Branch']) ? "selected" : ""; // Check if option is selected
       $options .= "<option value='" . $row['Branch'] . "' $selected>" . $row['Branch'] . "</option>";
}
}
echo $options;
?>
