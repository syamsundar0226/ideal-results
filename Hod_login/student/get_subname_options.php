<?php
// Connect to database
ini_set('memory_limit', '-1');
   session_start();
   include '../../connection.php';
   
   if (isset($_SESSION['username'])) 
   {
     $username = $_SESSION['username'];
   } 
   else 
   {
     header("Location: ../../index.html");
     exit();
   }
    

// Get batch, branch, year, and sem values from query string
$batch = $_GET['batch'];
$branch = $_GET['branch'];
$year = $_GET['year'];
$sem = $_GET['sem'];

// Build SQL query to get subname options based on batch, branch, year, and sem values
if (empty($branch)) {
$sql = "SELECT DISTINCT Subname FROM student_results WHERE Batch='$batch'  AND Year='$year' AND Sem='$sem'  ORDER BY Subname ASC";
} else {
    $sql = "SELECT DISTINCT Subname FROM student_results WHERE Batch='$batch' AND Branch='$branch' AND Year='$year' AND Sem='$sem' ORDER BY Subname ASC";
}
$result = mysqli_query($conn, $sql);

// Generate options for subname dropdown menu
$options = "<option value='' selected>Subject</option>";
while ($row = mysqli_fetch_array($result)) {
  $options .= "<option value='" . $row['Subname'] . "'>" . $row['Subname'] . "</option>";
}

echo $options;
?>
