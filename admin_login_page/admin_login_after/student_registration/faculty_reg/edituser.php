<?php
// Connect to the database
include '../../../../connection.php';
// Get the submitted form data
$sno = isset($_POST['sno']) ? $_POST['sno'] : array();
$name = isset($_POST['name']) ? $_POST['name'] : array();
$branch = isset($_POST['branch']) ? $_POST['branch'] : array();
$username = isset($_POST['username']) ? $_POST['username'] : array();
$password = isset($_POST['password']) ? $_POST['password'] : array();

// Loop through the submitted form data and update the database
if (count($sno) > 0) {
    for ($i = 0; $i < count($sno); $i++) {
        $sql = "UPDATE mentor_login SET name = '" . $name[$i] . "', branch = '" . $branch[$i] . "', username = '" . $username[$i] . "', password = '" . base64_encode($password[$i]) . "' WHERE sno = " . $sno[$i];
        mysqli_query($conn, $sql);
    }
}

// Close the database connection
mysqli_close($conn);

// Redirect back to the admin panel page
header('Location: user.php');
exit;
?>
