<?php

ini_set('memory_limit', '-1');
// Connect to database
session_start();
include '../../../../connection.php';
if (!isset($_SESSION['username'])) {
  header("Location: ../../../../index.html"); // Redirect to login page
  exit(); // Stop executing the rest of the code
}?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Faculty Registration</title>
  <link rel = "icon" href = "../../../../ideal_logo.jpg" type = "image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Handlee|Josefin+Sans:300,600&amp;display=swap'><link rel="stylesheet" href="./Admin.css">
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script  src="./user.js"></script>
</head>
</head>
<body>
	<img class="logo" src="../../../../ideal_logo A+.jpg" alt="College Logo" style="width: 100%;">
	<header>
		<h1>Faculty managment</h1>
		<a href="../../Admin login after.php" style="position: absolute; right: 50px; top: 125px; transform: translateY(-50%);">
  <i class="fa fa-home fa-2x" style="color: white;"></i>
</a>
	</header>
	<section>
	<nav>
		<ul>
			<li>Users</li>		
		</ul>
	</section>
	</nav>
	<section>
		<h2>Faculty details management</h2>
		<ul>
			<li><a href="#" id="Adduser">Add New User</a></li>
			<li><a href="#" id="Viewuser">View Users</a></li>
			<li><a href="#" id="edituser">Edit Users</a></li>
			<li><a href="#" id="deluser">Delete Users</a></li>
		</ul>
	</section>
	




	<section id=section1>
	<div id=myDiv>		
	<div class="add-user-form">
  <h2>Add User</h2>
  <form method="POST" action="adduser.php">
  	<div class="form-group">
               <label for="designation">Designation:</label>
               <input type="text" id="designation" name="designation" value="FACULTY" readonly>
               </div>
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
    </div>
    <!-- Add select2 CSS and JS files -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Add the select element with select2 initialized -->
<div class="form-group">
    <label for="branch">Branch:</label>
    <select name="branch" class="form-control select2" required>
        <option value="">Select Branch</option>
        <option value="COMPUTER SCIENCE AND ENGINEERING">CSE</option>
        <option value="AI & ML(CSE)">CSM</option>
        <option value="ELECTRICAL AND COMMUNICATION ENGINEERING">ECE</option>
        <option value="ELECTRICAL AND ELECTRONICS ENGINEERING ">EEE</option>
        <option value="MECHANICAL ENGINEERING">MECH</option>
        <option value="CIVIL ENGINEERING">CIVIL</option>
        <option value="COMPUTER SCIENCE">CS</option>
    </select>
</div>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>

    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
      <button type="submit">Add Faculty</button>
    </div>
  	</form>
		</div>
	</div>
	</section>




	<section id=section2>
	<div id=myDiv1>
	<div class="container">
		<h2>All Faculties</h2>
		<table>
			<tr>
				<th>SNo</th>
				<th>Name</th>
				<th>Branch</th>
				<th>Username</th>
				<th>Password</th>
			</tr>
			<?php
				// Connect to the database
			

			// Query the database to get all users
			$sql = "SELECT * FROM mentor_login WHERE designation = 'FACULTY'";
			$result = mysqli_query($conn, $sql);

			// Loop through the users and display them in the table
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>" . $row['sno'] . "</td>";
				echo "<td>" . $row['name'] . "</td>";
				echo "<td>" . $row['branch'] . "</td>";
				echo "<td>" . $row['username'] . "</td>";
				echo "<td>" . $row['password'] . "</td>";
				echo "</tr>";
			}

			// Close the database connection

			?>
		</table>
	</div>
	</div>
	</section>






 <section id=section3>
	<div id="myDiv2">
	  <h2>Edit Users</h2>
		<div class="useredit">
		<form id="edit-form" method="post" action="edituser.php">
		<table>
			<tr>
				<th>Sno</th>
				<th>name</th>
				<th>Branch</th>
				<th>Usernaame</th>
				<th>Password</th>
			</tr>
			<?php

					// Query the database to get all users
					$sql = "SELECT * FROM mentor_login WHERE designation = 'FACULTY'";
					$result = mysqli_query($conn, $sql);

					// Loop through the users and display them in the table
					while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td>" . $row['sno'] . "</td>";
							echo "<td><input type='text' name='name[]' value='" . $row['name'] . "'></td>";
							echo "<td><input type='text' name='branch[]' value='" . $row['branch'] . "'></td>";
							echo "<td><input type='text' name='username[]' value='" . $row['username'] . "'></td>";
							echo "<td><input type='password' name='password[]' value='" . base64_decode($row['password']) . "'></td>";
							echo "<input type='hidden' name='sno[]' value='" . $row['sno'] . "'>";
							echo "</tr>";
					}


				?>
					</table>
					<input type="submit" name="submit" value="Save Changes">

				</form>
			</div>
		</div>
	</section>




		<section id=section4>
  	<div id="myDiv3">
    <h2>Delete Users</h2>
    <table>
      <tr>
        <th>Sno</th>
        <th>Name</th>
        <th>Branch</th>
        <th>Username</th>
        <th>Delete</th>
      </tr>
      <?php
      // Connect to the database

      // Query the database to get all users
      $sql = "SELECT * FROM mentor_login WHERE designation = 'FACULTY'";
      $result = mysqli_query($conn, $sql);

      // Loop through the users and display them in the table
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['sno'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['branch'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td><button onclick='deleteUser(" . $row['sno'] . ")'>Delete</button></td>";
        echo "</tr>";
      }


      ?>
    </table>
  </div>
</section>





	
	<footer>
		<p>Ideal Institute Of Technology</p>
	</footer>
	
	</body>
</html>


