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
   
   if(isset($_SESSION['designation'])) 
   {
       $designation = $_SESSION['designation'];
   } 
// Get batch and branch values from query string
$batch = $_GET['batch'];
$branch = $_GET['branch'];

// Build SQL query to get year options based on batch and branch values
if ($designation == 'MENTOR') {
$sql = "SELECT DISTINCT Year FROM student_results WHERE Batch='$batch' AND Branch='$branch' AND Mentor='$username' ORDER BY Year ASC";
} else if ($designation == 'FACULTY') {
    $sql = "SELECT DISTINCT Year FROM student_results WHERE Batch='$batch' AND Branch='$branch' ORDER BY Year ASC";
}
$result = mysqli_query($conn, $sql);

// Generate options for year dropdown menu
$options = "<option value='' selected>Year</option>";
while ($row = mysqli_fetch_array($result)) {
  $options .= "<option value='" . $row['Year'] . "'>" . $row['Year'] . "</option>";
}

echo $options;
?>
