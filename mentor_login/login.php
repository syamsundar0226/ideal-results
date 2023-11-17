<?php
session_start();
require_once('../connection.php');
$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    echo "<script>alert('Please enter both username and password');window.location.href='index.html';</script>";
    exit();
}

$encoded_password = base64_encode($password); // Encode the entered password as base64

$stmt = $conn->prepare("SELECT sno, name, branch, username, password, designation FROM mentor_login WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $encoded_password); // Bind the encoded password to the query
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($sno, $name, $branch, $username, $password, $designation);

    // Fetch the results
    $stmt->fetch();

    $_SESSION['branch'] = $branch;
    $_SESSION['username'] = $username;
    $_SESSION['designation'] = $designation;
    $_SESSION['name'] = $name;
    $_SESSION['sno'] = $sno;

    echo "<script type='text/javascript' language='javascript'>window.location.assign('student/index.php');</script>";
    exit();
} else {
    echo "<script>alert('Invalid Username and Password');</script>";
    echo "<script>window.location.href='index.html';</script>";
}

$stmt->close();
?>
