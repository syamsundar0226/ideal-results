<?php
// Connect to database
session_start();
include '../../../../connection.php';
if (!isset($_SESSION['username'])) {
  header("Location: ../../../../index.html"); // Redirect to login page
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel = "icon" href = "../../../../ideal_logo.jpg" type = "image/x-icon">
    <style>
        body {
        background-color:#4a3d3d;; 
      }
    </style>
</head>
<body>
    <a href="../../Admin login after.php" style="position: absolute; right: 50px; top: 50px; transform: translateY(-50%);">
  <i class="fa fa-home fa-3x" style="color: white;"></i>
</a>
<div class="jumbotron text-center"style="background-color: #4a3d3d;">
    <h1 style="color: whitesmoke;">Upload Excel(CSV) file for student results</h1>
</div>
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
                <a href="../../../../Help/student results upload.csv" download>
                    <button style="background-color: #786e6e;
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
<div style="display: flex; justify-content: center; align-items: center; height: 30vh;">
    <form method="POST" action="cal credits.php" style="margin-right: 10px;">
        <input type="submit" name="cal" value="Calculate Credits Points" style="background-color: darkgreen; color: white; font-size: 16px; padding: 10px 10px; border: none; border-radius: 5px;">
    </form>
    <form method="POST" action="cal sgpa.php" style="margin-right: 10px;">
        <input type="submit" name="cal" value="Calculate GPA's" style="background-color: darkgreen; color: white; font-size: 16px; padding: 10px 10px; border: none; border-radius: 5px;">
    </form>
</div>
</body>
</html>
