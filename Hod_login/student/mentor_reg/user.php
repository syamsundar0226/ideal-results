<?php
   // Connect to database
   ini_set('memory_limit', '-1');
   session_start();
   include '../../../connection.php';
   if (!isset($_SESSION['username'])) {
     header("Location: ../../../index.html"); // Redirect to login page
     exit(); // Stop executing the rest of the code
   }
   if(isset($_SESSION['branch'])) 
      {
          $branch = $_SESSION['branch'];
      }?>
<!DOCTYPE html>
<html lang="en" >
   <head>
      <meta charset="UTF-8">
      <title>Mentor Registration</title>
      <link rel = "icon" href = "../../../ideal_logo.jpg" type = "image/x-icon">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css'>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Handlee|Josefin+Sans:300,600&amp;display=swap'>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="./Admin.css">
      <head>
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
         <script  src="./user.js"></script>
   </head>
   </head>
   <body>
      <style>.htno-row {
   display: flex;
   justify-content: space-between;
   margin-bottom: 10px;
}

.htno-label {
   margin-right: 5px;
}

      </style>
      <img class="logo" src="../../../ideal_logo A+.jpg" alt="College Logo" style="width: 100%;">
      <header>
         <h1>Mentor managment</h1>
         <a href="../index.php" style="position: absolute; right: 50px; top: 125px; transform: translateY(-50%);">
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
         <h2>Mentor details management</h2>
         <ul>
            <li><a href="#" id="Adduser">Add New Mentor</a></li>
            <li><a href="#" id="Viewuser">View User</a></li>
            <li><a href="#" id="edituser">Edit Mentor</a></li>
            <li><a href="#" id="deluser">Delete Mentor</a></li>
            <li><a href="#" id="managementor">Manage Mentor</a></li>
         </ul>
      </section>
      <section id="section1">
        <div id="myDiv">
            <div class="add-user-form">
                <h2>Add Mentor</h2>
                <form method="POST" action="adduser.php">
                    <div class="form-group">
                        <label for="designation">Designation:</label>
                        <input type="text" id="designation" name="designation" value="MENTOR" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="branch">Branch:</label>
                        <input type="text" id="branch" name="branch" value="<?php echo $branch; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Add Mentor</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

      <section id="section2">
    <div id="myDiv1">
        <div class="container">
            <h2>All Mentors and Faculty</h2>
            <table>
                <tr>
                    <th>SNo</th>
                    <th>Name</th>
                    <th>Branch</th>
                    <th>Username</th>
                    <th>Designation</th>
                    <th>Students Assigned</th>
                    <th>Delete</th>
                </tr>
                <?php
                // Query the database to get all users with their corresponding Htno
                $sql = "SELECT mentor_login.*, GROUP_CONCAT(DISTINCT student_results.Htno SEPARATOR ', ') AS Htno FROM mentor_login LEFT JOIN student_results ON mentor_login.username = student_results.Mentor  WHERE mentor_login.branch='$branch'  GROUP BY mentor_login.username";

                $result = mysqli_query($conn, $sql);

                // Loop through the users and display them in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['sno'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['branch'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['designation'] . "</td>";
                    echo "<td>" . $row['Htno'] . "</td>";
                    echo "<td><button onclick=\"deleteMentor('" . $row['username'] . "')\">Delete</button></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</section>

<script>
    function deleteMentor(username) {
        if (confirm("Are you sure you want to delete students for this mentor?")) {
            // Send an AJAX request to delete the mentor from the student_results table
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Reload the page to reflect the changes
                    location.reload();
                }
            };
            xhr.send("delete_mentor=true&username=" + username);
        }
    }
    
    <?php
    // Check if the delete_mentor parameter is set and delete the mentor from the student_results table
    if (isset($_POST['delete_mentor'])) {
        $username = $_POST['username'];
        $sql = "UPDATE student_results SET Mentor=NULL WHERE Mentor='$username'";
        mysqli_query($conn, $sql);
    }
    ?>
</script>

      <section id=section3>
         <div id="myDiv2">
            <h2>Edit Mentor</h2>
            <div class="useredit">
               <form id="edit-form" method="post" action="edituser.php">
                  <table>
                     <tr>
                        <th>Sno</th>
                        <th>name</th>
                        <th>Branch</th>
                        <th>Username</th>
                        <th>Password</th>
                     </tr>
                     <?php
                        // Query the database to get all users
                        $sql = "SELECT * FROM mentor_login WHERE branch='$branch' AND designation='MENTOR'";
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
            <h2>Delete Mentor</h2>
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
                  $sql = "SELECT * FROM mentor_login WHERE branch='$branch'";
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
<section id="section5">
   <div id="myDiv4">
      <h2>Assign Mentor</h2>
      <form action="update_mentor.php" method="post" class="assign-mentor-form">
         <div class="form-group">
            <label for="username">Username:</label>
            <select name="username" id="username" class="form-select">
               <?php
               // Connect to the database

               // Query the mentor_login table to get usernames with the specified conditions
               $sql = "SELECT username FROM mentor_login WHERE designation='MENTOR' AND branch='$branch' ORDER BY username ASC";
               $result = mysqli_query($conn, $sql);

               // Loop through the usernames and populate the first dropdown
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "<option value='" . $row['username'] . "'>" . $row['username'] . "</option>";
               }
               ?>
            </select>
         </div>

         <div class="form-group">
            <label for="batch">Batch:</label>
            <select name="batch" id="batch" onchange="populateHtno()" class="form-select">
               <?php
               // Query the student_results table to get batches with the specified condition
              $sql = "SELECT DISTINCT Batch FROM student_results WHERE Branch='$branch' ORDER BY Batch ASC";
               $result = mysqli_query($conn, $sql);

               // Loop through the batches and populate the second dropdown
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "<option value='" . $row['Batch'] . "'>" . $row['Batch'] . "</option>";
               }
               ?>
            </select>
         </div>

         <div id="htnoDiv" style="display: none;">
            <label for="htno">Htno:</label>
            <div id="htnoList"></div>
         </div>

         <div class="form-group">
            <button type="submit" class="btn">Assign Mentor</button>
         </div>
      </form>
   </div>
</section>


<script>
   var selectedHtnos = []; // Array to store selected Htno values

   function populateHtno() {
   var batch = document.getElementById("batch").value;
   var branch = "<?php echo $branch; ?>"; // Add this line to retrieve the branch value

   // Store the currently selected Htnos
   var checkboxes = document.querySelectorAll('.htno-checkbox');
   checkboxes.forEach(function(checkbox) {
      if (checkbox.checked) {
         selectedHtnos.push(checkbox.value);
      }
   });

   // Send an AJAX request to get the Htno values for the selected batch and branch
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         // Display the Htno checkboxes
         document.getElementById("htnoDiv").style.display = "block";
         document.getElementById("htnoList").innerHTML = this.responseText;

         // Check the previously selected checkboxes
         checkboxes = document.querySelectorAll('.htno-checkbox');
         checkboxes.forEach(function(checkbox) {
            if (selectedHtnos.includes(checkbox.value)) {
               checkbox.checked = true;
            }
         });
      }
   };
   xhttp.open("GET", "get_htno.php?batch=" + batch + "&branch=" + branch, true); // Pass both batch and branch values in the request
   xhttp.send();
}

   function updateSelectedHtnos(checkbox) {
      var htno = checkbox.value;
      if (checkbox.checked) {
         selectedHtnos.push(htno); // Add to selected Htnos
      } else {
         var index = selectedHtnos.indexOf(htno);
         if (index !== -1) {
            selectedHtnos.splice(index, 1); // Remove from selected Htnos
         }
      }
   }
</script>



      <footer>
         <p>Ideal Institute Of Technology</p>
      </footer>
   </body>
</html>