<?php
session_start();
require_once('../connection.php');
$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    echo "<script>alert('Please enter both username and password');window.location.href='student login.html';</script>";
    exit();
}

$encoded_password = base64_encode($password); // Encode the entered password as base64

$stmt = $conn->prepare("SELECT sno, Htno, branch, username, password FROM student_login WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $encoded_password); // Bind the encoded password to the query
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($sno, $Htno, $branch, $username, $password);

    // Fetch the results
    $stmt->fetch();

    $_SESSION['username'] = $username; 
    $_SESSION['password'] = $password; 

    // You can also store other values in the session if needed
    $_SESSION['sno'] = $sno;
    $_SESSION['Htno'] = $Htno;
    $_SESSION['branch'] = $branch;

    echo "<script type='text/javascript' language='javascript'>window.location.assign('result.php');</script>";
    exit();
} else {
    echo "<script>alert('Invalid Username and Password');</script>";
    echo "<script>window.location.href='student login.html';</script>";
}

$stmt->close();
?>
