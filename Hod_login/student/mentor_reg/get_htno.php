<?php
ini_set('memory_limit', '-1');
session_start();
include '../../../connection.php';

if (isset($_SESSION['branch'])) {
   $branch = $_SESSION['branch'];
}

// Retrieve the batch and branch values from the GET parameters
$batch = $_GET["batch"];


// Retrieve the combined Htno values from the session (previously selected + newly selected)
$selectedHtnos = isset($_SESSION['selectedHtnos']) ? $_SESSION['selectedHtnos'] : [];

// Query the student_results table to get the Htno values for the selected batch and branch
$sql = "SELECT DISTINCT Htno FROM student_results WHERE (Mentor IS NULL OR Mentor = '') AND Batch='$batch' AND Branch='$branch'";
$result = mysqli_query($conn, $sql);

// Generate the HTML for the Htno checkboxes
$htnoOptions = '';
$count = 0;
while ($row = mysqli_fetch_assoc($result)) {
   $htno = $row['Htno'];
   $checked = in_array($htno, $selectedHtnos) ? 'checked' : ''; // Check if the Htno is in the selectedHtnos array
   if ($count % 8 === 0) {
      $htnoOptions .= '<div class="htno-row">';
   }
   $htnoOptions .= "<label class='htno-label'>";
   $htnoOptions .= "<input type='checkbox' name='htno[]' value='$htno' class='htno-checkbox' $checked>";
   $htnoOptions .= "$htno";
   $htnoOptions .= "</label>";
   $count++;
   if ($count % 8 === 0) {
      $htnoOptions .= '</div>';
   }
}
// If the last row is not closed, close it
if ($count % 8 !== 0) {
   $htnoOptions .= '</div>';
}

echo $htnoOptions;
?>
