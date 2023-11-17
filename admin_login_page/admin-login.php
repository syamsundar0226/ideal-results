<?php
session_start();
require_once('../connection.php');
$username = $_POST['username'];
$password = $_POST['password'];
$validcode = $_POST['validcode'];

if (empty($username) || empty($password)) {
    echo "<script>alert('Please enter both username and password');window.location.href='admin_loginpage.html';</script>";
    exit();
}

$encoded_password = base64_encode($password); // Encode the entered password as base64

$stmt = $conn->prepare("SELECT sno, username, password, validcode, role FROM admin_login WHERE username=? AND password=? AND validcode=?");
$stmt->bind_param("sss", $username, $encoded_password, $validcode); // Bind the encoded password and validcode to the query
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($sno, $username, $password, $validcode, $role);

    // Fetch the results
    $stmt->fetch();

    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;
    $_SESSION['sno'] = $sno;

    echo "<script type='text/javascript' language='javascript'>window.location.assign('admin_login_after/Admin login after.php');</script>";
    exit();
} else {
    echo "<script>alert('Invalid Username, Password, or Valid Code');</script>";
    echo "<script>window.location.href='admin_loginpage.html';</script>";
}

$stmt->close();
?>
