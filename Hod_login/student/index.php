<?php
  $username='';
   $branch='';
   ini_set('memory_limit', '-1');
   session_start();
   include '../../connection.php';
   
   if (isset($_SESSION['username'])) {
     $username = $_SESSION['username'];
   } else {
     header("Location: ../../index.html");
     exit();
   }
    if(isset($_SESSION['name'])) {
       $name = $_SESSION['name'];
   }
   if(isset($_SESSION['branch'])) {
       $branch = $_SESSION['branch'];
   }
   
    
   if(empty($branch)) {
       $sql_br = "SELECT DISTINCT Branch FROM student_results ORDER BY Branch ASC";
       $result_br = mysqli_query($conn, $sql_br);
   $options_br = "<option value='' selected>Branch</option>"; // Add default option
   while ($row_br = mysqli_fetch_array($result_br)) {
       $options_br .= "<option value='" . $row_br['Branch'] . "'>" . $row_br['Branch'] . "</option>";
   }
   } else {
       $sql_br = "SELECT DISTINCT Branch FROM student_results WHERE Branch='$branch' ORDER BY Branch ASC";
       $result_br = mysqli_query($conn, $sql_br);
   $options_br = ""; // Remove default option
   while ($row_br = mysqli_fetch_array($result_br)) {
       $selected = ($branch == $row_br['Branch']) ? "selected" : ""; // Check if option is selected
       $options_br .= "<option value='" . $row_br['Branch'] . "' $selected>" . $row_br['Branch'] . "</option>";
   }
   }
   
   if(empty($branch)) {
       $sql_y = "SELECT DISTINCT Year FROM student_results ORDER BY Year ASC";
   } else {
       $sql_y = "SELECT DISTINCT Year FROM student_results WHERE Branch='$branch' ORDER BY Year ASC";
   }// Populate dropdown menu for Year
   $result_y = mysqli_query($conn, $sql_y);
   $options_y = "<option value='' selected>Year</option>"; // Add default option
   while ($row_y = mysqli_fetch_array($result_y)) {
       $options_y .= "<option value='" . $row_y['Year'] . "'>" . $row_y['Year'] . "</option>";
   }
   
   if(empty($branch)) {
       $sql_sem = "SELECT DISTINCT Sem FROM student_results ORDER BY Sem ASC";
   } else {
       $sql_sem = "SELECT DISTINCT Sem FROM student_results WHERE Branch='$branch' ORDER BY Sem ASC";
   }
   $result_sem = mysqli_query($conn, $sql_sem);
   $options_sem = "<option value='' selected>Sem</option>"; // Add default option
   while ($row_sem = mysqli_fetch_array($result_sem)) {
       $options_sem .= "<option value='" . $row_sem['Sem'] . "'>" . $row_sem['Sem'] . "</option>";
   }
   
   if(empty($branch)) {
       $sql_b = "SELECT DISTINCT Batch FROM student_results ORDER BY Batch ASC";
   } else {
       $sql_b = "SELECT DISTINCT Batch FROM student_results WHERE Branch='$branch' ORDER BY Batch ASC";
   }
   $result_b = mysqli_query($conn, $sql_b);
   $options_b = "<option value='' selected>Batch</option>"; // Add default option
   while ($row_b = mysqli_fetch_array($result_b)) {
       $options_b .= "<option value='" . $row_b['Batch'] . "'>" . $row_b['Batch'] . "</option>";
   }
   if(empty($branch)) {
       $sql_s = "SELECT DISTINCT Subname FROM student_results ORDER BY Subname ASC";
   } else {
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
   }    $result = mysqli_query($conn,$sql);
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
      <title>Admin Login</title>
      <link rel = "icon" href = "../../ideal_logo.jpg" type = "image/x-icon">
      <meta name="generator" content="Bootply" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" integrity="sha512-7+vTnOzAT/k77ugrG1YwZQ2KjFGhOOn1vMLF82Lpmdj9LHTh0jbAVPv+EjKjZd08GZ0/D6q3yn6UeLbTULX0TQ==" crossorigin="anonymous" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-BJl8XbN7I5/Ow+gS59V4P5lL4tN1FtduX9MK01Wu8g4GGkScLp/vDhOZo99MiRNt+4K4J1A06QdVJ+k+3QRvuw==" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js" integrity="sha512-Gk+ovZCz6q3q6DTTGg6yKj+wXJ70VyN8UI/jrN7ZJKzLk+83KbGOLxv/86eFe88pH9X+oB5If7+u8GJfV7x2ZQ==" crossorigin="anonymous"></script>
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
      <link href="css/styles.css" rel="stylesheet">
      <style>
      </style>
   </head>
   <body>
       
     <img class="logo" src="../../ideal_logo A+.jpg" alt="College Logo" style="min-width: 100px; max-width: 100%; height: auto; display: block; margin: 0 auto;">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a href="change_password/index.php" style="color: black; position: absolute;  left: 700px;">Change Password</a>
            <h4 style="padding-left: 100px;padding-top: 20px;"><?php echo "Welcome to Admin Panel " . strtoupper($name); ?></h4>
        <div>
            <a href="logout.php">
                <div class="logout-button">
                    <img src="logout-icon.png" alt="Logout">
                </div>
            </a>
        </div>
    </div>
     <br>
        <br>

             <?php
    $branch = $_SESSION['branch'];

    // Check if the branch is not empty
    if (!empty($branch)) {?>
     <div style="text-align: right;  position: relative;
      display: inline-block;
      float: right;
      margin-top: 10px;
      margin-right: 150px;">
    <button onclick="location.href='mentor_reg/user.php'" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px;">Mentor Management</button>
</div>
    <?php } 
?>
      
      </nav>
     

<!--reports-->
<br>
      <div class="dropdown">
         <button class="dropbtn" >Reports</button>
         <div class="dropdown-content">
            <script>var dropdown = document.querySelector('.dropdown-content');
             var button = document.querySelector('.dropbtn');

button.addEventListener('click', function() {
  dropdown.classList.toggle('show');
});</script>

             <!--student_results_X Table-->
            <a href="reports/Student_Results_X.php" name="Student_Results_X">Student Results X Table</a>
            <script>
               document.getElementById("Student_Results_X").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/Student_Results_X.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "Student_Results_X_Table.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>

        <a href="reports/fail_table.php" name="fail_table">FAIL TABLE</a>
            <a href="#">FAILED REPORTS</a>
            <a href="reports/R16_f.php" name="R16f">R16</a>
            <script>
               document.getElementById("R16f").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R16_f.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R16_Fail_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>


            <a href="reports/R19_f.php" name="R19f">R19</a>
            <script>
               document.getElementById("R19f").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R19_f.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R19_Fail_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="reports/R20_f.php" name="R20f">R20</a>
            <script>
               document.getElementById("R20f").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R20_f.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R20_Fail_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <!--23 reg -->
            <a href="reports/R23_f.php" name="R23f">R23</a>
            <script>
               document.getElementById("R23f").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R23_f.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R23_Fail_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script><a href="#">PASS REPORTS</a>
            <a href="reports/R16_pass.php" name="R16pass">R16</a>
            <script>
               document.getElementById("R16pass").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R16_pass.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R16_Pass_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="reports/R19_pass.php" name="R19pass">R19</a>
            <script>
               document.getElementById("R19pass").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R19_pass.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R19_Pass_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="reports/R20_pass.php" name="R20pass">R20</a>
            <script>
               document.getElementById("R20pass").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R20_pass.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R20_Pass_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <!--23 reg -->
            <a href="reports/R23_pass.php" name="R23pass">R23</a>
            <script>
               document.getElementById("R23pass").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R23_pass.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R23_Pass_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="#">Student Credits Report</a>
            <a href="reports/R16_st_credits.php" name="R16_st_credits">R16</a>
            <script>
               document.getElementById("R16_st_credits").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R16_st_credits.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R16_student_credits_report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="reports/R19_st_credits.php" name="R19_stu_credits">R19</a>
            <script>
               document.getElementById("R19_st_credits").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R19_st_credits.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R19_student_credits_report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="reports/R20_st_credits.php" name="R20_st_credits">R20</a>
            <script>
               document.getElementById("R20_st_credits").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R20_st_credits.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R20_student_credits_report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <!--23 reg -->
            <a href="reports/R23_st_credits.php" name="R23_st_credits">R23</a>
            <script>
               document.getElementById("R23_st_credits").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R23_st_credits.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R23_student_credits_report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="#">SUBJECT CREDITS REPORT</a>
            <a href="reports/R16_c.php" name="R16c">R16</a>
            <script>
               document.getElementById("R16c").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R16_c.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R16_Credits_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="reports/R19_c.php" name="R19c">R19</a>
            <script>
               document.getElementById("R19c").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R19_c.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R19_Credits_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="reports/R20_c.php" name="R20c">R20</a>
            <script>
               document.getElementById("R20c").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R20_c.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R20_Credits_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <!--23 reg-->
            <a href="reports/R23_c.php" name="R23c">R23</a>
            <script>
               document.getElementById("R23c").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R23_c.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R23_Credits_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="#">PERCENTAGE AND GPA REPORT</a>
            <a href="reports/R16_p.php" name="R16p">R16</a>
            <script>
               document.getElementById("R16p").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R16_p.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R16_Percentage_and_GPA_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="reports/R19_p.php" name="R19p">R19</a>
            <script>
               document.getElementById("R19p").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R19_p.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R19_Percentage_and_GPA_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <a href="reports/R20_p.php" name="R20p">R20</a>
            <script>
               document.getElementById("R20p").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R20_p.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R20_Percentage_and_GPA_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
            <!--23 reg-->
            <a href="reports/R23_p.php" name="R23p">R23</a>
            <script>
               document.getElementById("R23p").addEventListener("click", function() {
                   var xhr = new XMLHttpRequest();
                   xhr.open("POST", "reports/R23_p.php");
                   xhr.responseType = "blob";
                   xhr.onload = function() {
                       if (this.status === 200) {
                           var blob = new Blob([this.response], {type: "text/csv"});
                           var url = URL.createObjectURL(blob);
                           var a = document.createElement("a");
                           a.href = url;
                           a.download = "R23_Percentage_and_GPA_Report.csv";
                           a.click();
                       }
                   };
                   xhr.send(new FormData());
               });
            </script>
         </div>
      </div>
      <!--mainbody-->
      <br>
      <br>
     <div class="container-fluid">
    <div style="display: flex; justify-content: space-between; align-items: center; text-align: center; margin-left: 10px;">
        <div>
            <div class="col-xs-12" style="margin: auto;">
                <form method="POST" style="display: inline-block; margin: auto;">
                    
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
                               <th scope="col" style="text-align: center;">Fee Paid count</th>
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
                           $strength = $passCount + $failCount;
                           ?>
                        <tbody>
                           <tr>
                               <td><?php echo $strength; ?>
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
                        <?php  }} ?>
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
      <hr>
      <div class="row">
         <div class="col-xs-12">
            <?php if (isset($_POST['form_search'])) 
               {
                   if(isset($_SESSION['branch'])) {
               $branch = $_SESSION['branch'];
               }
                   $sdata=$_POST['search'];?>
            <?php
             
              if (empty($branch)) {
    $query_details = "SELECT * FROM student_details WHERE htno = '$sdata'";
} else {
    $query_details = "SELECT * FROM student_details WHERE htno = '$sdata' AND branch='$branch'";
}
$result_details = mysqli_query($conn, $query_details);
$image_filename = "../../images/" . strtoupper($sdata) . ".jpg";

if (mysqli_num_rows($result_details) > 0) {
    $row = mysqli_fetch_assoc($result_details);
    echo '<div style="width: 100%; overflow-x: auto;">'; // Added container div with CSS styling
    echo '<table class="student-table" style="width: 90%; text-align: left;">'; // Set table width to 100%
    echo '<tr class="student-row">';
    echo '<td class="student-image" style="text-align: center;"><img src="' . $image_filename . '" alt="Student Image"></td>';
    echo '<td class="student-details">';
    echo '<table class="details-table" style="width: 100%;">'; // Set nested table width to 100%
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
    echo '</div>';
} else {
    // Display message if student details not found
    echo '<div class="no-details">';
    echo '<h2><p>NOTE: Student details not found</p></h2>';
    echo '</div>';
}
?>
            <?php
            if(empty($branch)) {
       $ret = mysqli_query($conn, "SELECT * FROM student_results WHERE Htno = '$sdata'ORDER BY Year, Sem");
   } else {
       $ret = mysqli_query($conn, "SELECT * FROM student_results WHERE Htno = '$sdata' AND Branch = '$branch' ORDER BY Year, Sem");
   }
               
               $num=mysqli_num_rows($ret);
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
               
               if($num>0){
                   $current_year = "";
                                         $current_sem = "";
                                         $f_count = 0; // New line to declare and initialize total F count variable
                                         echo '<hr>';
                                         echo '<div class="row">';
                                         echo '<tbody>';
               $cnt=1;
               while ($row=mysqli_fetch_array($ret)) {
               
               if ($row['Year'] != $current_year || $row['Sem'] != $current_sem) 
                                           {
                                             // Close the previous table (if any) and open a new one
                                             if ($current_year != "" && $current_sem != "") 
                                             {
                                               echo '</tbody>';
                                               echo '</table>';
                                             }
                                             $current_year = $row['Year'];
                                             $current_sem = $row['Sem'];
                                             echo '<table class="table table-bordered" width="100%" border="0" style="padding-left:40px">';
                                             echo '<thead>';
                                             echo '<tr>';
                                             echo '<th colspan="11">Year ' . $current_year . ' - Semester ' . $current_sem . '</th>';
                                             echo '</tr>';
                                             echo '<tr>';
                                             echo '<th scope="col" style="text-align: center;">Sno</th>';
                                             echo '<th scope="col" style="text-align: center;">Batch</th>';
                                             echo '<th scope="col" style="text-align: center;">Branch</th>';
                                             echo '<th scope="col" style="text-align: center;">Subcode</th>';
                                             echo '<th scope="col" style="text-align: left;">Subname</th>';
                                             echo '<th scope="col" style="text-align: left;">Internals</th>';
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
                                         if(empty($branch)) {
       $query = "SELECT * FROM student_details WHERE htno = '$sdata' ";
   } else {
       $query = "SELECT * FROM student_details WHERE htno = '$sdata' AND branch = '$branch'";
   }
                                       
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
