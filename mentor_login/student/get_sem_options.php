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

// Get batch, branch, and year values from query string
$batch = $_GET['batch'];
$branch = $_GET['branch'];
$year = $_GET['year'];

// Build SQL query to get sem options based on batch, branch, and year values
 if ($designation == 'MENTOR') {
$sql = "SELECT DISTINCT Sem FROM student_results WHERE Batch='$batch' AND Branch='$branch' AND Year='$year' AND Mentor='$username' ORDER BY Sem ASC";
} else if ($designation == 'FACULTY') {
    $sql = "SELECT DISTINCT Sem FROM student_results WHERE Batch='$batch' AND Branch='$branch' AND Year='$year' ORDER BY Sem ASC";
}
$result = mysqli_query($conn, $sql);

// Generate options for sem dropdown menu
$options = "<option value='' selected>Sem</option>";
while ($row = mysqli_fetch_array($result)) {
  $options .= "<option value='" . $row['Sem'] . "'>" . $row['Sem'] . "</option>";
}

echo $options;
?>
