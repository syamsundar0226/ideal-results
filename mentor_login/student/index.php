<?php

   $username='';
   $branch='';
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
   if(isset($_SESSION['branch'])) 
   {
       $branch = $_SESSION['branch'];
   } 
   if(isset($_SESSION['designation'])) 
   {
       $designation = $_SESSION['designation'];
   }
   if(isset($_SESSION['name'])) 
   {
       $name = $_SESSION['name'];
   }
 $sql_roll = "SELECT DISTINCT Htno FROM student_results WHERE Branch='$branch' AND Mentor='$username' ORDER BY Htno ASC";
   // Populate dropdown menu for Rollnumbers
   $result_roll = mysqli_query($conn, $sql_roll);
   $options_roll = "<option value='' selected>Your Students</option>"; // Add default option
   while ($row_roll = mysqli_fetch_array($result_roll)) {
       $options_roll .= "<option value='" . $row_roll['Htno'] . "'>" . $row_roll['Htno'] . "</option>";
   }


   $sql_br = "SELECT DISTINCT Branch FROM student_results WHERE Branch='$branch' ORDER BY Branch ASC";
   $result_br = mysqli_query($conn, $sql_br);
   $options_br = ""; 
   while ($row_br = mysqli_fetch_array($result_br)) 
   {
       $selected = ($branch == $row_br['Branch']) ? "selected" : ""; // Check if option is selected
       $options_br .= "<option value='" . $row_br['Branch'] . "' $selected>" . $row_br['Branch'] . "</option>";
   }
   
   
   
   if ($designation == 'MENTOR') {
    $sql_y = "SELECT DISTINCT Year FROM student_results WHERE Branch='$branch' AND Mentor='$username' ORDER BY Year ASC";
} else if ($designation == 'FACULTY') {
    $sql_y = "SELECT DISTINCT Year FROM student_results WHERE Branch='$branch' ORDER BY Year ASC";
}


   // Populate dropdown menu for Year
   $result_y = mysqli_query($conn, $sql_y);
   $options_y = "<option value='' selected>Year</option>"; // Add default option
   while ($row_y = mysqli_fetch_array($result_y)) {
       $options_y .= "<option value='" . $row_y['Year'] . "'>" . $row_y['Year'] . "</option>";
   }
   
   if ($designation == 'MENTOR')
    {
   $sql_sem = "SELECT DISTINCT Sem FROM student_results WHERE Branch='$branch' AND Mentor='$username' ORDER BY Sem ASC";
   } else if ($designation == 'FACULTY') 
   {
    $sql_sem = "SELECT DISTINCT Sem FROM student_results WHERE Branch='$branch' ORDER BY Sem ASC";
}
   $result_sem = mysqli_query($conn, $sql_sem);
   $options_sem = "<option value='' selected>Sem</option>"; // Add default option
   while ($row_sem = mysqli_fetch_array($result_sem)) {
       $options_sem .= "<option value='" . $row_sem['Sem'] . "'>" . $row_sem['Sem'] . "</option>";
   }
   
   if ($designation == 'MENTOR') {
    $sql_b = "SELECT DISTINCT Batch FROM student_results WHERE Branch='$branch' AND Mentor='$username' ORDER BY Batch ASC";
} else if($designation == 'FACULTY') {
    $sql_b = "SELECT DISTINCT Batch FROM student_results WHERE Branch='$branch' ORDER BY Batch ASC";
}

   $result_b = mysqli_query($conn, $sql_b);
   $options_b = "<option value='' selected>Batch</option>"; // Add default option
   while ($row_b = mysqli_fetch_array($result_b)) {
       $options_b .= "<option value='" . $row_b['Batch'] . "'>" . $row_b['Batch'] . "</option>";
   }
   if ($designation == 'MENTOR') {
   $sql_s = "SELECT DISTINCT Subname FROM student_results WHERE Branch='$branch' AND Mentor='$username' ORDER BY Subname ASC";
   } else if($designation == 'FACULTY') {
    $sql_s = "SELECT DISTINCT Subname FROM student_results WHERE Branch='$branch' ORDER BY Subname ASC";
}
   $result_s = mysqli_query($conn, $sql_s);
   $options_s = "<option value='' selected>Subject</option>";
   while ($row_s = mysqli_fetch_array($result_s)) {
       $options_s .= "<option value='" . $row_s['Subname'] . "'>" . $row_s['Subname'] . "</option>";
   }
   // When form is submitted, store selected values in variables and generate SQL query
   $result = null;
   // Get selected values from dropdown menus
   $branch = '';
   $year = '';
   $sem = '';
   $batch = '';
   $subname = '';
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $branch = isset($_POST['branch']) ? $_POST['branch'] : '';
   $year = isset($_POST['year']) ? $_POST['year'] : '';
   $sem = isset($_POST['sem']) ? $_POST['sem'] : '';
   $batch = isset($_POST['batch']) ? $_POST['batch'] : '';
   $subname = isset($_POST['subname']) ? $_POST['subname'] : '';
   
   // Build SQL query based on selected values
   $sql = "SELECT * FROM student_results WHERE 1=1";
if (!empty($branch)) {
    $sql .= " AND Branch='$branch'";
}
if (!empty($year)) {
    $sql .= " AND Year='$year'";
}
if (!empty($sem)) {
    $sql .= " AND Sem='$sem'";
}
if (!empty($batch)) {
    $sql .= " AND Batch='$batch'";
}
if (!empty($grade)) {
    $sql .= " AND Grade='$grade'";
}
if (!empty($subname)) {
    $sql .= " AND Subname='$subname'";
}

// Add condition to check if Mentor name matches with $username
if ($designation == "MENTOR") {
    if (!empty($username)) {
        $sql .= " AND Mentor='$username'";
    }
}

$result = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
      <title>Faculty Login</title>
      <link rel = "icon" href = "../../ideal_logo.jpg" type = "image/x-icon">
      <meta name="generator" content="Bootply" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
      <link href="css/styles.css" rel="stylesheet">
   </head>
   <body>
      <img class="logo" src="../../ideal_logo A+.jpg" alt="College Logo" style="min-width: 100px; max-width: 100%; height: auto; display: block; margin: 0 auto;">

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a href="change_password/index.php" style="color: black; position: absolute;  left: 700px;">Change Password</a>
        <h4 style="padding-left: 20px; padding-top: 20px;"><?php echo "Welcome to Faculty Panel " . strtoupper($name); ?></h4>
        <div>
            <a href="logout.php">
                <div class="logout-button">
                    <img src="logout-icon.png" alt="Logout">
                </div>
            </a>
        </div>
    </div>
</nav>
      <!--mainbody-->
      <br>
      <br>
     <div class="container-fluid">
    <div style="display: flex; justify-content: space-between; align-items: center; text-align: center; margin-left: 10px;">
        <div>
            <div class="col-xs-12" style="margin: auto;">
                <form method="POST" style="display: inline-block; margin: auto;">
                    <?php if($designation == 'MENTOR') { ?>
                        <label for="rollnumbers">Roll Number:</label>
                        <select name="rollnumbers" id="rollnumbers">
                            <?php echo $options_roll; ?>
                        </select>
                    <?php } ?>

                    <input type="text" name="search" placeholder="Enter Roll Number" required style="background-color: #d6d6d6;">
                    <input type="hidden" name="form_search" value="1">
                    <button type="submit" name="submit_search">Search</button>
                </form>
                <hr>
               <form method="POST" style="display: inline-block; margin: auto;">
                    <label for="batch"></label>
                    <select name="batch" id="batch" required style="background-color: #d6d6d6;">
                        <?php echo $options_b; ?>
                    </select>
                    <label for="branch"></label>
                    <select id="branch" name="branch" style="background-color: #d6d6d6;">
                        <?php echo $options_br; ?>
                    </select>
                    <label for="year"></label>
                    <select name="year" id="year" style="background-color: #d6d6d6;">
                        <?php echo $options_y; ?>
                    </select>
                    <label for="sem"></label>
                    <select name="sem" id="sem" style="background-color: #d6d6d6;">
                        <?php echo $options_sem; ?>
                    </select>
                    <label for="subname"></label>
                    <select name="subname" id="subname" style="background-color: #d6d6d6;">
                        <?php echo $options_s; ?>
                    </select>
                    <input type="hidden" name="form_options" value="1">
                    <button type="submit" name="submit_options">Submit Options</button>
                </form>
                <script>
  const batchDropdown = document.getElementById('batch');
  const branchDropdown = document.getElementById('branch');
  const yearDropdown = document.getElementById('year');
  const semDropdown = document.getElementById('sem');
  const subnameDropdown = document.getElementById('subname');

  batchDropdown.addEventListener('change', updateBranchOptions);
  branchDropdown.addEventListener('change', updateYearOptions);
  yearDropdown.addEventListener('change', updateSemOptions);
  semDropdown.addEventListener('change', updateSubnameOptions);

  function updateBranchOptions() {
    const batchValue = batchDropdown.value;
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_branch_options.php?batch=' + batchValue);
    xhr.onload = function() {
      if (xhr.status === 200) {
        branchDropdown.innerHTML = xhr.responseText;
        updateYearOptions();
      }
    };
    xhr.send();
  }

  function updateYearOptions() {
    const batchValue = batchDropdown.value;
    const branchValue = branchDropdown.value;
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_year_options.php?batch=' + batchValue + '&branch=' + branchValue);
    xhr.onload = function() {
      if (xhr.status === 200) {
        yearDropdown.innerHTML = xhr.responseText;
        updateSemOptions();
      }
    };
    xhr.send();
  }

  function updateSemOptions() {
    const batchValue = batchDropdown.value;
    const branchValue = branchDropdown.value;
    const yearValue = yearDropdown.value;
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_sem_options.php?batch=' + batchValue + '&branch=' + branchValue + '&year=' + yearValue);
    xhr.onload = function() {
      if (xhr.status === 200) {
        semDropdown.innerHTML = xhr.responseText;
        updateSubnameOptions();
      }
    };
    xhr.send();
  }

  function updateSubnameOptions() {
    const batchValue = batchDropdown.value;
    const branchValue = branchDropdown.value;
    const yearValue = yearDropdown.value;
    const semValue = semDropdown.value;
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_subname_options.php?batch=' + batchValue + '&branch=' + branchValue + '&year=' + yearValue + '&sem=' + semValue);
    xhr.onload = function() {
      if (xhr.status === 200) {
        subnameDropdown.innerHTML = xhr.responseText;
      }
    };
    xhr.send();
  }
</script>
                <p style="text-align: center;"><button onclick="window.print()" style="font-size: 16px; color: red; background-color: transparent; border: none;">Print</button></p>
            </div>
        </div>
        
    </div>
</div>

<hr>
            <div class="row">
               <div class="col-xs-12">
                <?php
                     if (isset($_POST['form_options'])) {
                     if ($result && mysqli_num_rows($result) > 0) {
                     ?> 
                  <hr>
                  <div class="row">
                     <h3>Students with Number of Backlogs</h3>
                     <table class="table table-bordered" width="100%" border="0" >
                        <thead>
                           <tr>
                            <th scope="col" style="text-align: center;">Students</th>
                            <th scope="col" style="text-align: center;">Number of Backlogs</th>
                           </tr>
                        </thead>
                        <?php
                          $backlogs = array();
while ($row = mysqli_fetch_assoc($result)) {
    $htno = $row['Htno'];
    $grades = explode(',', $row['Grade']);
    $last_grade = end($grades);
    if (!isset($backlogs[$htno])) {
        $backlogs[$htno] = 0;
    }
    if ($last_grade == 'F' || $last_grade == 'ABSENT') {
        $backlogs[$htno]++;
    }
}

                           $backlogsCount = array(
                               '0' => 0,
                               '1' => 0,
                               '2' => 0,
                               '3' => 0,
                               'moreThan3' => 0,
                           );
                           foreach ($backlogs as $htno => $count) 
                           {
                               if ($count == 0) {
                                   $backlogsCount['0']++;
                               } elseif ($count == 1) {
                                   $backlogsCount['1']++;
                               } elseif ($count == 2) {
                                   $backlogsCount['2']++;
                               } elseif ($count == 3) {
                                   $backlogsCount['3']++;
                               } else {
                                   $backlogsCount['moreThan3']++;
                               }
                           }
                           ?>
                        <tbody>
                           <tr>
                              <td>0 Backlogs</td>
                              <td><?php echo $backlogsCount['0']; ?></td>
                           </tr>
                           <tr>
                              <td>1 Backlog</td>
                              <td><?php echo $backlogsCount['1']; ?></td>
                           </tr>
                           <tr>
                              <td>2 Backlogs</td>
                              <td><?php echo $backlogsCount['2']; ?></td>
                           </tr>
                           <tr>
                              <td>3 Backlogs</td>
                              <td><?php echo $backlogsCount['3']; ?></td>
                           </tr>
                           <tr>
                              <td>More than 3 Backlogs</td>
                              <td><?php echo $backlogsCount['moreThan3']; ?></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <?php mysqli_data_seek($result, 0);?> 
                  <hr>
                  <div class="row">
                     <h3>Exam Statistics</h3>
                     <table class="table table-bordered" width="100%" border="0">
                        <thead>
                           <tr>
                              <th scope="col" style="text-align: center;">Appeared</th>
                              <th scope="col" style="text-align: center;">No of Pass</th>
                              <th scope="col" style="text-align: center;">No of Fail</th>
                              <th scope="col" style="text-align: center;">Pass percentage</th>
                           </tr>
                        </thead>
                        <?php
                          $backlogs = array();
$appeared = array();
while ($row = mysqli_fetch_assoc($result)) {
    $htno = $row['Htno'];
    $grades = explode(',', $row['Grade']); // split grades by comma
    $grade = end($grades); // get the last grade
    if (!isset($backlogs[$htno])) {
        $backlogs[$htno] = 0;
    }
    if ($grade != 'ABSENT') { // skip students with absent grades
        if (!in_array($htno, $appeared)) {
            $appeared[] = $htno;
        }
        if ($grade == 'F') {
            $backlogs[$htno]++;
        }
    }
}

                           $passCount = $backlogsCount['0'];
                           $failCount = array_sum(array_slice($backlogsCount, 1));
                           $totalCount = count($appeared); // use count of appeared array instead
                           $passPercentage = round(($passCount / $totalCount) * 100, 2);
                           
                           ?>
                        <tbody>
                           <tr>
                              <td><?php echo count($appeared); ?></td>
                              <td><?php echo $passCount; ?></td>
                              <td><?php echo $failCount; ?></td>
                              <td><?php echo $passPercentage; ?>%</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <?php mysqli_data_seek($result, 0);?>
                  <hr>
                  <div class="row">
                     <h3>Subject Statistics</h3>
                     <table class="table table-bordered" width="100%" border="0" >
                        <thead>
                          <tr>
                             <th scope="col" style="text-align: center;">Sno</th>
                              <th scope="col" style="text-align: center;">Subcode</th>
                              <th scope="col">Subname</th>
                             <th scope="col" style="text-align: center;">No of Pass</th>
                              <th scope="col" style="text-align: center;">No of Fail</th>
                              <th scope="col" style="text-align: center;">Absent</th>
                              <th scope="col" style="text-align: center;">Pass Percentage</th>
                           </tr>
                        </thead>
                        <?php
                           $cnt = 1;
$subjects = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Count grades for each subject
    $subcode = $row['Subcode'];
    if (!isset($subjects[$subcode])) {
        $subjects[$subcode] = array(
            'Subcode' => $row['Subcode'],
            'Subname' => $row['Subname'],
            'NoOfPass' => 0,
            'NoOfFail' => 0,
            'Absent' => 0,
            'TotalGrades' => 0,
        );
    }
    $grades = explode(',', $row['Grade']);
    $last_grade = end($grades);
    if (!empty($last_grade)) {
        $subjects[$subcode]['TotalGrades']++;
    }
    if ($last_grade != 'ABSENT' && $last_grade != 'F') {
        $subjects[$subcode]['NoOfPass']++;
    } elseif ($last_grade == 'F') {
        $subjects[$subcode]['NoOfFail']++;
    } elseif ($last_grade == 'ABSENT') {
        $subjects[$subcode]['Absent']++;
    }
}

                           foreach ($subjects as $sub) {
                           ?>
                         <tbody>
                           <tr data-expanded="true">
                              <td><?php echo $cnt; ?></td>
                              <td><?php echo $sub['Subcode']; ?></td>
                              <td style="text-align: left;"><?php echo $sub['Subname']; ?></td>
                              <td><?php echo $sub['NoOfPass']; ?></td>
                              <td><?php echo $sub['NoOfFail']; ?></td>
                              <td><?php echo $sub['Absent']; ?></td>
                              <td><?php echo round(($sub['NoOfPass'] / $sub['TotalGrades']) * 100, 2); ?>%</td>
                           </tr>
                        </tbody>
                        <?php
                           $cnt++;
                           }
                           
                           } else { ?>
                        <tr>
                           <td colspan="8"> No records found</td>
                        </tr>
                        <?php  } }?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <!--/center-->
         <hr>
      </div>
      <!--/container-fluid-->
      <!-- script references -->
      <hr>
      <div class="row">
         <div class="col-xs-12">
            <?php
if (isset($_POST['form_search'])) {
    if (isset($_SESSION['branch'])) {
        $branch = $_SESSION['branch'];
    }
    $sdata = $_POST['search'];

    if ($designation == 'MENTOR') {
        $sql = "SELECT * FROM student_results WHERE Htno = '$sdata' AND Branch = '$branch' AND Mentor = '$username'";
    } else if ($designation == 'FACULTY') {
        $sql = "SELECT * FROM student_results WHERE Htno = '$sdata' AND Branch = '$branch'";
    }

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // Display student details
        $query_details = "SELECT * FROM student_details WHERE htno = '$sdata' AND branch='$branch' ";
        $result_details = mysqli_query($conn, $query_details);
        $image_filename = "../../images/" . strtoupper($sdata) . ".jpg";
        if (mysqli_num_rows($result_details) > 0) {
            $row = mysqli_fetch_assoc($result_details);
            echo '<table class="student-table" style="width: 100px; text-align:left;">';
            echo '<tr class="student-row" style="margin-left: 10px;"><td class="student-image" style="padding-left: 5px;"><img src="' . $image_filename . '" alt="Student Image"></td>';
            echo '<td class="student-details">';
            echo '<table class="details-table">';
            echo '<tr><td><h4><b>Name:</b></h4></td><td><h5>' . $row['st_name'] . '</h5></td></tr>';
            echo '<tr><td><h4><b>Rollnumber:</b></h4></td><td><h5>' . $row['htno'] . '</h5></td></tr>';
            echo '<tr><td><h4><b>Branch:</b></h4></td><td><h5>' . $row['branch'] . '</h5></td></tr>';
            echo '<tr><td><h4><b>Regulation:</b></h4></td><td><h5>' . $row['regulation'] . '</h5></td></tr>';
            echo '<tr><td><h4><b>Student Phone No.:</b></h4></td><td><h5>' . $row['st_phone'] . '</h5></td></tr>';
            echo '<tr><td><h4><b>Parent Phone No.:</b></h4></td><td><h5>' . $row['parent_phone'] . '</h5></td></tr>';
            echo '<tr><td><h4><b>10th:</b></h4></td><td><h5>' . $row['10th'] . '</h5></td></tr>';
            echo '<tr><td><h4><b>Inter/Diploma:</b></h4></td><td><h5>' . $row['12th_or_diploma'] . '</h5></td></tr>';
            echo '<tr><td><h4><b>Gmail:</b></h4></td><td><h5>' . $row['gmail'] . '</h5></td></tr>';
            echo '</table>';
            echo '</td></tr>';
            echo '</table>';
        } else {
            // Display message if student details not found
            echo '<div class="no-details">';
            echo '<h2><p>NOTE: Student details not found<h2></p>';
            echo '</div>';
        }

        // Display grades and results
        $ret = mysqli_query($conn, "SELECT * FROM student_results WHERE Htno = '$sdata' AND Branch = '$branch' ORDER BY Year, Sem");
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
        if ($num > 0) {
            $bg_color = ($f_count == 0) ? 'green' : 'red';
            if ($f_count == 0) {
                echo '<div class="all-clear" style="background-color: ' . $bg_color . ';">All Clear</div>';
            } else {
                echo '<div class="backlogs" style="background-color: ' . $bg_color . ';">Total Backlogs : ' . $f_count . '</div>';
            }
        }
        echo '</div>';

        if ($num > 0) {
            $current_year = "";
            $current_sem = "";
            $f_count = 0; // New line to declare and initialize total F count variable
            echo '<hr>';
            echo '<div class="row">';
            echo '<tbody>';
            $cnt = 1;
            while ($row = mysqli_fetch_array($ret)) {
                if ($row['Year'] != $current_year || $row['Sem'] != $current_sem) {
                    // Close the previous table (if any) and open a new one
                    if ($current_year != "" && $current_sem != "") {
                        echo '</tbody>';
                        echo '</table>';
                    }
                    $current_year = $row['Year'];
                    $current_sem = $row['Sem'];
                    echo '<table class="table table-bordered" width="100%" border="0" >';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th  colspan="11">Year ' . $current_year . ' - Semester ' . $current_sem . '</th>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<th scope="col" style="text-align: center;">Sno</th>';
                    echo '<th scope="col" style="text-align: center;">Batch</th>';
                    echo '<th scope="col" style="text-align: center;">Branch</th>';
                    echo '<th scope="col" style="text-align: center;">Subcode</th>';
                    echo '<th scope="col" style="text-align: left;">Subname</th>';
                    echo '<th scope="col" style="text-align: center;">Internals</th>';
                    echo '<th scope="col" style="text-align: center;">Grade</th>';
                    echo '<th scope="col" style="text-align: center;">Credits</th>';
                    echo '<th scope="col" style="text-align: center;">Result Date</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    $cnt = 1;
                }
                echo '<tr data-expanded="true">';
                echo '<td>' . $cnt . '</td>';
                echo '<td style="text-align: left; white-space: nowrap;">' . $row['Batch'] . '</td>';
                echo '<td style="text-align: left;">' . $row['Branch'] . '</td>';
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
                echo '>' . $row['Grade'] . '</td>';

                echo '<td>' . $row['Credits'] . '</td>';
                echo '<td>' . $row['Result_date'] . '</td>';
                echo '</tr>';
                $cnt = $cnt + 1;
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }

        $query = "SELECT * FROM student_details WHERE htno = '$sdata' AND branch = '$branch'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  echo '<table class="grades-table">';
  echo '<tr><th style="text-align: center;">GPA</th><th style="text-align: center;">Points</th></tr>';
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
    }
} else {
    echo '<div class="no-details">';
    echo '<h2><p>This Student is not Assigned to you<h2></p>';
    echo '</div>';
}
?>

            </tbody>
            </table>
         </div>
      </div>
      </div>  
      </div><!--/center-->
      <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>