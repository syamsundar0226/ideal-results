<?php
// Connect to database
ini_set('memory_limit', '-1');
session_start();
include '../../../connection.php';
if (!isset($_SESSION['username'])) {
  header("Location: ../../../index.html"); // Redirect to login page
  exit(); // Stop executing the rest of the code
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Excel(CSV) file</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel = "icon" href = "../../../ideal_logo.jpg" type = "image/x-icon">
    <style>
        body {
        background-color: #786e6e; 
      }
     button {
  background-color: darkgoldenrod;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
button 
.btn1{
    position: fixed;
  bottom: 50px;
  left: 50px;
}
.btn2{
    position: fixed;
  bottom: 50px;
  right: 50px;
}
button:hover {
    background: #086325;
}

button:focus {
    background: #086325;
    box-shadow: none;
}
.logo{
 width: 100px;
 height: 100px;
}
</style>
</head>
<body>

<div class="jumbotron text-center"style="background-color: #4a3d3d;">
    <img class="logo" src="../../../ideal_logo.jpg" alt="top">
    <h1 style="color: white;">Upload Excel(CSV) file for student registration</h1>
    <a href="../Admin login after.php" style="position: absolute; right: 30px; top: 50px; transform: translateY(-50%);">
  <i class="fa fa-home fa-3x" style="color: white;"></i>
</a>



</div>
<h3 style="text-align: center;margin-right: 800px;"><b>Student Login Details Upload</b></h3>
<div class="container">
    <form action="excel-script.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <input type="file" name="excelDoc" id="excelDoc" class="form-control" required />
            </div>
        </div>
        <div class="col-md-4">
            <input type="submit" name="uploadBtn" id="uploadBtn" value="Upload Excel" class="btn btn-success" />
        </div>
    </div>
    </form>

    <div class="col-md-4 text-center">
        <a href="../../../Help/Student Login Details.csv" download>
            <button style="background-color: #4a3d3d;
                            border: none;
                            color: white;
                            padding: 10px 20px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 16px;
                            margin: 4px 2px;
                            cursor: pointer;
                            border-radius: 5px;
                            float: left;">
                <i class="fas fa-download" style="margin-right: 5px;"></i> Sample Download
            </button>
        </a>
    </div>
    <div>
        <form method="POST" action="pgenerate.php" style="display: inline;">
            <button type="submit" style="background-color: #4a3d3d; border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 5px;">
                Password Generator
            </button>
        </form>
    </div>
</div>

<h3 style="text-align: center; margin-right: 870px;"><b>Student Details Upload</b></h3>
<div class="container">
    <form action="excel-script_1.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <input type="file" name="excelDoc" id="excelDoc" class="form-control" required />
            </div>
        </div>
        <div class="col-md-4">
            <input type="submit" name="uploadBtn" id="uploadBtn" value="Upload Excel" class="btn btn-success" />
        </div>
    </div>
    </form>

    <div class="col-md-4 text-center">
                <a href="../../../Help/student_details.csv" download>
                    <button style="background-color: #4a3d3d;
                            border: none;
                            color: white;
                            padding: 10px 20px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 16px;
                            margin: 4px 2px;
                            cursor: pointer;
                            border-radius: 5px;
                            float: left;">
                        <i class="fas fa-download" style="margin-right: 5px;"></i> Sample Download
                    </button>
                </a>
            </div>
</div>
<h2 style="margin-left: 200px;"><strong> Admin and Faculty Registration </strong></h2>
<button style="margin-bottom: 30px; margin-left: 200px;"id="btn2" onclick="location.href='hod_reg/user.php'">Admin registration</button>
<button style="margin-bottom: 30px; margin-left: 200px;" id="btn1" onclick="location.href='faculty_reg/user.php'">Faculty registration</button>

</body>
</html>
