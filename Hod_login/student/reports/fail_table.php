<?php
  $username='';
   $branch='';
   ini_set('memory_limit', '-1');
   session_start();
   include '../../../connection.php';
   
   if (isset($_SESSION['username'])) {
     $username = $_SESSION['username'];
   } else {
     header("Location: ../../../index.html");
     exit();
   }
   
   if(isset($_SESSION['branch'])) {
       $branch = $_SESSION['branch'];
   }

?>
<!DOCTYPE html>
<html>
<head>
<title>Student Results</title>
<link rel = "icon" href = "../../../ideal_logo.jpg" type = "image/x-icon">
<link rel="stylesheet" type="text/css" href="style.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css'>
<script>
function showSubject(subnames) {
  var subnameArray = subnames.split(",");
  var subnameList = "";
  for (var i = 0; i < subnameArray.length; i++) {
    var subname = subnameArray[i].trim();
    var yearSem = subname.substring(subname.lastIndexOf("(") + 1, subname.lastIndexOf(")"));
    subname = subname.replace(yearSem, "");
    subnameList += "<li>" + subname + " - " + yearSem + "</li>";
  }
  var modal = document.createElement("div");
  modal.style.position = "fixed";
  modal.style.top = "0";
  modal.style.left = "0";
  modal.style.width = "100%";
  modal.style.height = "100%";
  modal.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
  modal.style.display = "flex";
  modal.style.justifyContent = "center";
  modal.style.alignItems = "center";
  modal.innerHTML = "<div style='background-color: white; padding: 10px; max-height: 80%; overflow-y: auto;'>" + "<ul>" + subnameList + "</ul>" + "</div>";
  document.body.appendChild(modal);
  modal.addEventListener("click", function() {
    document.body.removeChild(modal);
  });
}
</script>

</head>
<body>

  <img class="logo" src="../../../ideal_logo A+.jpg" alt="College Logo" style="padding: 0 100px;height: 150px; width: 1200px; margin-left: 70px;">
  <p style="text-align: center;"><button onclick="window.print()" style="font-size: 16px; color: red; background-color: transparent; border: none;">Print</button></p>
  <a href="../index.php" style="position: absolute; right: 50px; top: 70px; transform: translateY(-50%);">
         <i class="fa fa-home fa-2x" style="color: black;"></i>
         </a>
  <div id="subnameList"></div>
<?php

// Retrieve distinct batch values from database
if(empty($branch)) {
  $sql = "SELECT DISTINCT Batch FROM student_results ORDER BY Batch ASC";
  } else {
    $sql = "SELECT DISTINCT Batch FROM student_results WHERE Branch='$branch' ORDER BY Batch ASC";
  }
$result = $conn->query($sql);

// Output batch selection dropdown menu and search field
echo "<div class='form-container'>";
echo "<form method='post'>";
echo "<label for='batch'></label>";
echo "<select id='batch' name='batch'>";
echo "<option value='' selected>Select Batch</option>";
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row["Batch"] . "'>" . $row["Batch"] . "</option>";
}
echo "</select>";
echo "<label for='search'></label>";
echo "<input type='text' id='search' name='search' size='10' placeholder='Enter Roll Number'>";
echo "<input type='submit' name='submit' value='Submit'>";
echo "</form>";
echo "</div>";

// Retrieve data from database based on selected batch and search query
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$batch = $_POST["batch"];
$search = $_POST["search"];
} else {
$batch = "";
$search = "";
}
$conn->query("SET SESSION group_concat_max_len = 1000000;");
if(isset($_SESSION['branch'])) {
               $branch = $_SESSION['branch'];
               }
if(empty($branch)) {
  $sql = "SELECT student_results.Htno, 
  SUM(CASE WHEN Year = 1 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem1,
  SUM(CASE WHEN Year = 1 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem2,
  SUM(CASE WHEN Year = 2 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem3,
  SUM(CASE WHEN Year = 2 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem4,
  SUM(CASE WHEN Year = 3 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem5,
  SUM(CASE WHEN Year = 3 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem6,
  SUM(CASE WHEN Year = 4 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem7,
  SUM(CASE WHEN Year = 4 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem8,
  SUM(CASE WHEN SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Total,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 1 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem1_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 1 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem2_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 2 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem3_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 2 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem4_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 3 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem5_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 3 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem6_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 4 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem7_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 4 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem8_Subnames
  FROM student_results
  LEFT JOIN (SELECT DISTINCT Htno FROM student_results WHERE Batch = '$batch' AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT')) AS failed_results ON student_results.Htno = failed_results.Htno
  WHERE ('$batch' = '' OR student_results.Batch = '$batch') AND student_results.Htno LIKE '%$search%'
  GROUP BY student_results.Htno
  ORDER BY student_results.Htno ASC";
} else {
  $sql = "SELECT student_results.Htno, 
  SUM(CASE WHEN Year = 1 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem1,
  SUM(CASE WHEN Year = 1 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem2,
  SUM(CASE WHEN Year = 2 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem3,
  SUM(CASE WHEN Year = 2 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem4,
  SUM(CASE WHEN Year = 3 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem5,
  SUM(CASE WHEN Year = 3 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem6,
  SUM(CASE WHEN Year = 4 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem7,
  SUM(CASE WHEN Year = 4 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Sem8,
  SUM(CASE WHEN SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) AS Total,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 1 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem1_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 1 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem2_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 2 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem3_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 2 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem4_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 3 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem5_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 3 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem6_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 4 AND Sem = 1 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem7_Subnames,
  GROUP_CONCAT(DISTINCT CASE WHEN Year = 4 AND Sem = 2 AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT') THEN Subname ELSE NULL END SEPARATOR ',') AS Sem8_Subnames
  FROM student_results
  LEFT JOIN (SELECT DISTINCT Htno FROM student_results WHERE Batch = '$batch' AND SUBSTRING_INDEX(Grade, ',', -1) IN ('F', 'ABSENT')) AS failed_results ON student_results.Htno = failed_results.Htno
  WHERE ('$batch' = '' OR student_results.Batch = '$batch') AND student_results.Htno LIKE '%$search%' AND student_results.Branch = '$branch'
  GROUP BY student_results.Htno
  ORDER BY student_results.Htno ASC";
}

$result = $conn->query($sql);


// Output data as table
if ($result->num_rows > 0) {
echo "<table><tr><th>Htno</th><th>Sem1</th><th>Sem2</th><th>Sem3</th><th>Sem4</th><th>Sem5</th><th>Sem6</th><th>Sem7</th><th>Sem8</th><th>Total</th></tr>";
while($row = $result->fetch_assoc()) {
echo "<tr><td>" . $row["Htno"] . "</td><td>" . $row["Sem1"] . "</td><td>" . $row["Sem2"] . "</td><td>" . $row["Sem3"] . "</td><td>" . $row["Sem4"] . "</td><td>" . $row["Sem5"] . "</td><td>" . $row["Sem6"] . "</td><td>" . $row["Sem7"] . "</td><td>" . $row["Sem8"] . "</td><td><a href='#' onclick='showSubject(\"" . $row["Sem1_Subnames"] . "," . $row["Sem2_Subnames"] . "," . $row["Sem3_Subnames"] . "," . $row["Sem4_Subnames"] . "," . $row["Sem5_Subnames"] . "," . $row["Sem6_Subnames"] . "," . $row["Sem7_Subnames"] . "," . $row["Sem8_Subnames"] . "\")'>" . $row["Total"] . "</a></td></tr>";
}
echo "</table>";
} else {
echo "0 results";
}

// Close database connection
$conn->close();
?>
</body>
</html>
