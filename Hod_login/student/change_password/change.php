<?php
ini_set('memory_limit', '-1');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollnumber = $_POST["rollnumber"];
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Perform validation and update password in the database

    include '../../../connection.php';

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        header("Location: ../../index.html");
        exit();
    }

    if ($rollnumber == $username) {
    if ($newPassword === $confirmPassword) {
        $encodedPassword = base64_encode($newPassword);
        // Update the password
        $sql = "UPDATE hod_login SET password='$encodedPassword' WHERE username='$rollnumber'";

        if ($conn->query($sql) === TRUE) {
            // Use alert() to display success message
            echo "<script>alert('Password updated successfully.');window.location.href='../../index.html';</script>";
            exit();
        } else {
            // Use alert() to display error message
            echo "<script>alert('Error updating password: " . $conn->error . "');window.location.href='index.php';</script>";
            exit();
        }
    } else {
        // Use alert() to display error message
        echo "<script>alert('New password and confirm password do not match.');window.location.href='index.php';</script>";
        exit();
    }

    $conn->close();
} else {
    // Use alert() to display error message
    echo "<script>alert('Invalid user ID.');window.location.href='index.php';</script>";
    exit();
}

}
?>
