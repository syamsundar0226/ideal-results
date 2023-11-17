  <?php
  // Your PHP code to connect to the database goes here
include '../../../../connection.php';
  // Query the database to get all users
  $query = "SELECT * FROM mentor_login";
  $result = mysqli_query($conn, $query);

  // Convert the result set into an array of users
  $users = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
  }
  ?>
