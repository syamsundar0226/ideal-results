<?php
// Database connection details
ini_set('memory_limit', '-1');
session_start();
include '../../../connection.php';
if (!isset($_SESSION['username'])) {
  header("Location: ../../../index.html"); // Redirect to login page
  exit(); // Stop executing the rest of the code
}

// Length of each password
$password_length = 10;
$uploadError = "";
$passwordGenerated = false;

// Update passwords for users whose password column is empty or null
$sql = "SELECT username, password FROM student_login WHERE password IS NULL OR password = ''";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $username = $row["username"];
    $currentPassword = $row["password"];

    $password = generate_password($password_length);
    $password_encrypted = base64_encode($password); // Convert password to Base64 encryption

    $updateSql = "UPDATE student_login SET password='$password_encrypted' WHERE username='$username'";
    if ($conn->query($updateSql) !== TRUE) {
        $uploadError .= "<script>alert('Error updating password for user: $username<br>');window.location.href='index.php';</script>";
    } else {
        $passwordGenerated = true;
    }
}

// Generate the message based on password generation
if ($passwordGenerated) {
    $message = "Passwords generated successfully. The file will start downloading shortly.";
} else {
    $message = "No empty passwords found. The file will start downloading shortly.";
}

// Download CSV file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=student_logins.csv');

// Output CSV file directly to the browser
$output = fopen('php://output', 'w');
fputcsv($output, array('Htno', 'branch', 'username', 'password'));

$query = "SELECT Htno, branch, username, password FROM student_login ORDER BY Htno ASC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    // Decode password from Base64 encryption
    $password_decoded = base64_decode($row['password']);
    $row['password'] = $password_decoded;
    fputcsv($output, $row);
}

fclose($output);

// Close the database connection after the file download
$conn->close();

// Function to generate random password
function generate_password($length)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = "";
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
}
?>
