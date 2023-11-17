<?php
include '../../../../connection.php';
$name = $_POST['name'];
$branch = $_POST['branch'];
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("INSERT INTO hod_login(name, branch, username, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $branch, $username, base64_encode($password));
$execval = $stmt->execute();

if (!$execval) {
    echo "<script>alert('The username already exists. Please choose a different username.');window.location.href='user.php';</script>";
} else {
    echo "<script>alert('Registration successful.');window.location.href='user.php';</script>";
}

$stmt->close();
$conn->close();

header('Location: user.php');
exit;
?>
