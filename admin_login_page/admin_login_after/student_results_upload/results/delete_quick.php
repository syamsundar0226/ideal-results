 <?php
 include '../../../../connection.php';
  // Check if the delete button was clicked
  if(isset($_POST['delete'])) {
    // Connect to the database
    
    // SQL query to delete the table
    $sql = "TRUNCATE TABLE quick_results";
    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Qucik Results Data Deleted Successfully');window.location.href='index.php';</script>";
    } else {
      echo "Error deleting table: " . $conn->error;
    }
    $conn->close();
  }
  ?>
