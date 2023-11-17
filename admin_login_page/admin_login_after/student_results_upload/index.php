<?php 
  session_start();
  if (!isset($_SESSION['username'])) {
    header("Location: ../../../index.html"); // Redirect to login page
    exit(); // Stop executing the rest of the code
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Results upload</title>
  <link rel="icon" href="ideal_logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <a href="../Admin login after.php" style="position: absolute; right: 50px; top: 50px; transform: translateY(-50%);">
    <i class="fa fa-home fa-2x" style="color: black;"></i>
  </a>
  <img class="logo" src="../../../ideal_logo A+.jpg" alt="College Logo" style="padding: 0 100px;height: 150px; width: 1350px;">
  <div class="cards-list">
    <a href="results/index.php" class="card 1">
      <div class="card_image">
        <img src="https://i.redd.it/b3esnz5ra34y.jpg" />
      </div>
      <div class="card_title title-white">
        <p>Reg/Sup Results</p>
      </div>
    </a>
    <a href="results/ind_quick.php" class="card 2">
      <div class="card_image">
        <img src="https://i.redd.it/b3esnz5ra34y.jpg" />
      </div>
      <div class="card_title title-white">
        <p>Quick Results</p>
      </div>
    </a>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</body>
</html>
