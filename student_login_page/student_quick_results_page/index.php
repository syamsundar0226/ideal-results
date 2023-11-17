<?php
ini_set('memory_limit', '-1');
require_once("../../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Student Results</title>
    <link rel = "icon" href = "../../ideal_logo.jpg" type = "image/x-icon">
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">
	</head>
	<body>
        <img class="logo" src="../../ideal_logo A+.jpg" alt="College Logo" style="width: 100%;">
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-header">
     
		<h4 style="padding-left: 70px; padding-top: 15px;">Student Results</h4>
      </div>
      <a href="../student login.html" style="position: absolute; left: 20px; top: 30px; transform: translateY(-50%);">
  <i class="fa fa-arrow-left fa-2x" style="color: black;"></i>
</a>

    </nav>

<div class="container-fluid">

  
  <!--center-->
  <div class="col-sm-8">
    <div class="row">
      <div class="col-xs-12">
        <h3 style="padding-left: 100px;">Enter Student Rollnumber </h3>
		<hr >

    <form name="bwdatesdata" action="" method="post" action="">
  <table width="100%" height="117"  border="0">
<tr>
    <th width="27%" height="63" scope="row">Student ID :</th>

    <td width="73%">
<input id="searchdata" type="text" name="searchdata" required="true" class="form-control">
      </td>
  </tr>

<tr>
    <th width="27%" height="63" scope="row"></th>
    <td width="73%">
      <button class="btn-primary btn" type="submit" name="search">Confirm</button>
  </tr>
</table>
     </form>
 
      </div>
    </div>
    <hr>

      <div class="row">
      <div class="col-xs-12">
      	 <?php
if(isset($_POST['search']))
{ 

$sdata=$_POST['searchdata'];
  ?>
        <h3 style="padding-left: 100px;color:blue">Result of "<?php echo $sdata;?>"</h3>
		<hr >
		<div class="row">
                            <table class="table table-bordered" width="100%"  border="0" style="padding-left:40px">
                                <thead>
                                    <tr>
                                        <th scope="col">Sno</th>
                                        <th scope="col">Htno</th>
                                        <th scope="col">Subcode</th>
                                        <th scope="col">Subname</th>
                                        <th scope="col">Internals</th>
                                        <th scope="col">Grade</th>
                                        <th scope="col">Credits</th>
                                      
                                    </tr>
                                </thead>
                                <?php
$ret=mysqli_query($conn,"select * from  quick_results where  Htno like '%$sdata%' || Subcode like '%$sdata%' || Subname like '%$sdata%' || Internals like '%$sdata%' || Grade like '%$sdata%' || Credits like '%$sdata%'");
$num=mysqli_num_rows($ret);
if($num>0){
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
                                <tbody>
                                    <tr data-expanded="true">
            <td><?php echo $cnt;?></td>

                  <td><?php  echo $row['Htno'];?></td>
                  <td><?php  echo $row['Subcode'];?></td>
                  <td><?php  echo $row['Subname'];?></td>
                  <td><?php  echo $row['Internals'];?></td>
                  <td><?php  echo $row['Grade'];?></td>
                  <td><?php  echo $row['Credits'];?></td>
                </tr>
                 <?php 
$cnt=$cnt+1;
} } else { ?>
  <tr>
    <td colspan="8"> No record found with this student ID</td>

  </tr>
   
<?php } }?>
                                    
                                    
                                   
                                   
                                </tbody>
                            </table>
                           
                        </div>
 
      </div>
    </div>  
   
  </div><!--/center-->

  <hr>
</div><!--/container-fluid-->
	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>