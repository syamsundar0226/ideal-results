<?php
	include '../../../../connection.php';
	$name = $_POST['name'];
	$branch = $_POST['branch'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$designation=$_POST['designation'];

	// Check if username already exists
	$checkStmt = $conn->prepare("SELECT COUNT(*) FROM mentor_login WHERE username = ?");
	$checkStmt->bind_param("s", $username);
	$checkStmt->execute();
	$checkResult = $checkStmt->get_result();
	$count = $checkResult->fetch_assoc()['COUNT(*)'];
	$checkStmt->close();

	if ($count > 0) {
		// Username already exists, display alert message
		echo "<script>alert('Username already exists. Please choose a different username.');window.location.href='user.php';</script>";
		exit;
	}

	// Insert into the table
	$stmt = $conn->prepare("INSERT INTO mentor_login(name, branch, username, password, designation) VALUES(?, ?, ?, ?, ?)");
	$stmt->bind_param("sssss", $name, $branch, $username, base64_encode($password), $designation);
	$execval = $stmt->execute();
	echo"<script>alert('Registration successfully...');window.location.href='user.php';</script>";
	$stmt->close();
	$conn->close();

	header('Location: user.php');
	exit;
?>
