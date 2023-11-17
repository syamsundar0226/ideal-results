<?php 
class Common 
{
    public function uploadData($conn,$sno,$Htno,$branch,$username,$password) 
    {
        // Check if Htno already exists in database
        $query = "SELECT * FROM student_login WHERE Htno = '$Htno'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) 
        {
            // Htno already exists, update the row in both tables
            $query = "UPDATE student_login SET branch='$branch', username='$username', password='" . base64_encode($password) . "'  WHERE Htno='$Htno'";
            $result = $conn->query($query);
            
        } 
        else 
        {
            // Htno does not exist, insert row into both tables
            $query = "INSERT INTO student_login (Htno, branch, username, password, ) VALUES ('$Htno', '$branch', '$username', '" . base64_encode($password) . "')";
            $result = $conn->query($query);
            
        }
    }
}
?>