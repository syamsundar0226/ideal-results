<?php
   // Start a session to store user data
   ini_set('memory_limit', '-1');
   session_start();
   include '../connection.php';
   
   if (isset($_SESSION['username'])) {
     $username = $_SESSION['username'];
   } else {
     header("Location: ../index.html");
     exit();
   }
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta name="viewport" content="width=1024"">
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
      <title>Student Results</title>
      <link rel = "icon" href = "../ideal_logo.jpg" type = "image/x-icon">
      <meta name="generator" content="Bootply" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-xxxxxxxxxxx
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
      <link href="css/styles.css" rel="stylesheet">
      <style>
    /* Add the following CSS rules to adjust the table layout */
    .table-responsive {
      overflow-x: auto;
    }
    .table thead th {
      white-space: nowrap;
    }
    .logo {
      width: 100%;
      max-height: 200px; /* Adjust the value as needed */
      object-fit: contain;
    }
    .table-container {
  overflow-x: auto;
}

.details-table td {
  text-align: left;
}

.student-row {
  margin-left: 10px;
}

.student-image {
  padding-left: 5px;
  vertical-align: middle;
  text-align: center;
}

.details-table {
  width: 100%;
}
    @media only screen and (max-width: 600px) {
  .student-row {
    display: block;
  }

  .student-image {
    text-align: center;
    padding: 0;
    margin-bottom: 10px;
  }
}
  </style>
   </head>
   <body>
      <div class="row">
   <div class="col-xs-12">
      <div class="logout-button">
         <a href="logout.php">
            <img src="logout-icon.png" alt="Logout">
         </a>
      </div>
      <a href="change_password/index.php" style="color: black; position: absolute; top: 0; left: 0;">Change Password</a>
      
      <img class="logo" src="../ideal_logo A+.jpg" alt="College Logo">
   </div>
</div>

      <hr>
      <div class="row">
      <div class="col-xs-12">
      <p style="text-align: center;"><button onclick="window.print()" style="font-size: 16px; color: red; background-color: transparent; border: none;">Print</button>
      </p>
      <?php
      echo '<div class="table table-responsive" style="text-align: center;">';
         // Connect to database
         $query_details = "SELECT * FROM student_details WHERE htno = '$username'";
         $result_details = mysqli_query($conn, $query_details);
         $image_filename = "../images/" . $username .".jpg";
         
         if (mysqli_num_rows($result_details) > 0) {
    $row = mysqli_fetch_assoc($result_details);
    echo '<div class="table-container">';
    echo '<table class="student-table">';
    echo '<tr class="student-row"><td class="student-image" style="vertical-align: middle; text-align: center "><img src="' . $image_filename . '" alt="Student Image"></td>';
    echo '<td class="student-details">';
    echo '<table class="details-table">';
    echo '<tr><td><h5><b>Name:</b></h5></td><td><h5>' . $row['st_name'] . '</h5></td></tr>';
    echo '<tr><td><h5><b>Rollnumber:</b></h5></td><td><h5>' . $row['htno'] . '</h5></td></tr>';
    echo '<tr><td><h5><b>Branch:</b></h5></td><td><h5>' . $row['branch'] . '</h5></td></tr>';
    echo '<tr><td><h4><b>Regulation:</b></h4></td><td><h5>' . $row['regulation'] . '</h5></td></tr>';
    echo '</table>';
    echo '</td></tr>';
    echo '</table>';
    echo '</div>';
}
 else {
           // Display message if student details not found
           echo '<div class="no-details">';
           echo '<h2><p>NOTE: Student details not found<h2></p>'; 
           echo '</div>';
           
         }
         ?>
      <?php
         $ret = mysqli_query($conn, "SELECT * FROM student_results WHERE Htno = '$username' ORDER BY Year, Sem");
         $num = mysqli_num_rows($ret);
         $f_count = 0; // initialize total F count variable
         while ($row = mysqli_fetch_array($ret)) {
                            $grades = explode(',', $row['Grade']);
         $last_grade = end($grades);
                            if ($last_grade == 'F' || $last_grade == 'ABSENT') {
                                $f_count++; // increment F grade count
                            }
                        }
         mysqli_data_seek($ret, 0); // reset the result set pointer
         
         echo '<div class="table" style="text-align: center;">';
         $bg_color = ($f_count == 0) ? 'green' : 'red';
         if ($f_count == 0) {
           echo '<div class="all-clear" style="background-color: ' . $bg_color . ';">All Clear</div>';
         } else {
           echo '<div class="backlogs" style="background-color: ' . $bg_color . ';">Total Backlogs : ' . $f_count . '</div>';
         }
         echo '</div>';
         
         if($num>0){
             echo '<div class="table table-responsive" style="text-align: center;">';
             $current_year = "";
                                   $current_sem = "";
                                   echo '<hr>';
                                   echo '<div  class="row">';
                                   echo '<tbody>';
         $cnt=1;
         while ($row=mysqli_fetch_array($ret)) {
             if ($row['Year'] != $current_year || $row['Sem'] != $current_sem) {
                 // Close the previous table (if any) and open a new one
                 if ($current_year != "" && $current_sem != "") {
                     echo '</tbody>';
                     echo '</table>';
                 }
                 $current_year = $row['Year'];
                 $current_sem = $row['Sem'];
                 echo '<table class="table table-bordered" width="100%" border="0" style="padding-left:40px">';
                 echo '<thead>';
                 echo '<tr>';
                 echo '<th colspan="11" style="text-align: left;">Year ' . $current_year . ' - Semester ' . $current_sem . '</th>';
                 echo '</tr>';
                 echo '<tr>';
                 echo '<th scope="col" width="30">Sno</th>';
                 echo '<th scope="col" width="70">Subcode</th>';
                 echo '<th scope="col" width="200">Subname</th>';
                 echo '<th scope="col" width="50">Internals</th>';
                 echo '<th scope="col" width="50">Grade</th>';
                 echo '<th scope="col" width="50">Credits</th>';
                 echo '</tr>';
                 echo '</thead>';
                 echo '<tbody>';
                 $cnt = 1;
             }
             echo '<tr data-expanded="true">';
             echo '<td>' . $cnt . '</td>';
             echo '<td style="text-align: left;">' . $row['Subcode'] . '</td>';
             echo '<td style="text-align: left;">' . $row['Subname'] . '</td>';
             echo '<td>' . $row['Internals'] . '</td>';
             echo '<td';
         $grades = explode(',', $row['Grade']);
         $last_grade = end($grades);
         if ($last_grade == 'F' || $last_grade == 'ABSENT') {
             echo ' style="background-color: crimson; color: #f1f1f1; font-weight: bold"'; // Apply red color to F grade
             $f_count++; // Increment F grade count
         }
         echo '>' . $last_grade . '</td>';
         
             echo '<td>' . $row['Credits'] . '</td>';
             echo '</tr>';
             $cnt = $cnt + 1;
         }
         echo '</tbody>';
         echo '</table>';
         echo '</div>';
         echo'</div>';
         }         
             $query = "SELECT * FROM student_details WHERE Htno = '$username' ";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  echo '<table class="grades-table">';
  echo '<tr><th>GPA</th><th>Points</th></tr>';
  echo '<tr><td>Sem 1</td><td>' . $row['Year1sem1'] . '</td></tr>';
  echo '<tr><td>Sem 2</td><td>' . $row['Year1sem2'] . '</td></tr>';
  echo '<tr><td>Sem 3</td><td>' . $row['Year2sem1'] . '</td></tr>';
  echo '<tr><td>Sem 4</td><td>' . $row['Year2sem2'] . '</td></tr>';
  echo '<tr><td>Sem 5</td><td>' . $row['Year3sem1'] . '</td></tr>';
  echo '<tr><td>Sem 6</td><td>' . $row['Year3sem2'] . '</td></tr>';
  echo '<tr><td>Sem 7</td><td>' . $row['Year4sem1'] . '</td></tr>';
  echo '<tr><td>Sem 8</td><td>' . $row['Year4sem2'] . '</td></tr>';
  echo '<tr><td>CGPA</td><td>' . $row['CGPA'] . '</td></tr>';
  echo '<tr><td>Percentage</td><td>' . $row['Per'] . '</td></tr>';
  echo '</table>';
}

           ?>
      <!--/container-fluid-->
      <!-- script references -->
      <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>