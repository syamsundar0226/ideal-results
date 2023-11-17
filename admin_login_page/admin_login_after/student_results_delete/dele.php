<?php
// Connect to database
ini_set('memory_limit', '-1');
session_start();
include '../../../connection.php';
if (!isset($_SESSION['username'])) {
  header("Location: ../../../index.html"); // Redirect to login page
  exit(); // Stop executing the rest of the code
}

  // Check if the delete button was clicked
  if(isset($_POST['delete'])) {
    // Connect to the database
    
    // SQL query to delete the table
    $sql = "TRUNCATE TABLE student_results";
    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Student results deleted successfully');window.location.href='dele.php';</script>";
    } else {
      echo "Error deleting table: " . $conn->error;
    }
    $conn->close();
  }

  if (isset($_POST['export'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Htno','Regulation','Year','Sem','Batch','Branch','Subcode', 'Subname', 'Grade','Actual Credits' ,'Credits', 'Credits_pts','Result_date', 'Mentor'));
    $query = "SELECT Htno,Regulation, Year , Sem , Batch , Branch , Subcode , Subname , Grade ,Actual_credits, Credits , Credits_pts, Result_date, Mentor from student_results ORDER BY Htno ASC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Delete Table</title>
  <link rel = "icon" href = "../../../ideal_logo.jpg" type = "image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
        body {
        background-color: #e6d8d8; 
      }
.logo{
 width: 100px;
 height: 100px;
}


</style>
</head>
<body>
  <img class="logo" src="../../../ideal_logo.jpg" alt="top">
  <h1 style="text-align: center; color: red; font-size: 24px; font-weight: bold;"> Download student results  before deleting.</h1> 
  <div class="csv_section">
        <div class="export_section"></div>
            <form class="form-horizontal" action="" method="post" name="uploadCSV" enctype="multipart/form-data">
                <div class="input-row" >
                  <div style="text-align: center;">
                    <button type="submit" id="submit" name="export" class="btn-submit" style="background-color: brown; color: white; font-size: 16px; padding: 20px 20px; border: none; border-radius: 5px;">Download Results</button>
                </div>
                <div id="response"></div>
            </form>
        </div>
    </div>
  <h2 style="text-align: center;">Delete button to delete entire table which contain student results in database.</h2>
  <a href="../Admin login after.php" style="position: absolute; right: 50px; top: 50px; transform: translateY(-50%);">
  <i class="fa fa-home fa-3x" style="color: black;"></i>
</a>
  <form method="post">
  <div style="text-align: center;">
    <input type="submit" name="delete" value="Delete Results" style="background-color: brown; color: white; font-size: 16px; padding: 20px 20px; border: none; border-radius: 5px;">
  </div>
  </form>
</body>
</html>