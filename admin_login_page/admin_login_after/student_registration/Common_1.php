<?php
class Common 
{
    public function uploadData($conn,$sno,$Htno,$regulation,$branch,$st_name,$st_phone,$parent_phone,$tenth,$inter_or_diploma,$gmail) 
    {
        // Check if Htno already exists in database
        $query = "SELECT * FROM student_details WHERE htno = '$Htno'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) 
        {
            // Htno already exists, update student_details table
            $query = "UPDATE student_details SET regulation='$regulation',branch='$branch', st_name='$st_name', st_phone='$st_phone', parent_phone='$parent_phone', 10th='$tenth', 12th_or_diploma='$inter_or_diploma', gmail='$gmail' WHERE htno='$Htno'";
            $result = $conn->query($query);
            
            // Update student_credits table
            $query = "UPDATE student_credits SET regulation='$regulation', branch='$branch' WHERE htno='$Htno'";
            $result = $conn->query($query);
        } else 
        {
            // Htno does not exist, insert row into student_details table
            $query = "INSERT INTO student_details (htno,regulation, branch, st_name, st_phone, parent_phone, 10th, 12th_or_diploma, gmail) VALUES ('$Htno','$regulation','$branch', '$st_name', '$st_phone','$parent_phone','$tenth','$inter_or_diploma','$gmail')";
            $result = $conn->query($query);
            
            // Insert row into student_credits table
            $query = "INSERT INTO student_credits (htno, branch) VALUES ('$Htno','$regulation', '$branch')";
            $result = $conn->query($query);
            
            if ($result) 
            {
                return true;
            } 
            else 
            {
                return false;
            }
        }
    }
}
?>
