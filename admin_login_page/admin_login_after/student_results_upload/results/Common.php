<?php 

class Common
{
    public function uploadData($conn, $Htno, $Year, $Sem, $Batch, $Branch, $Subcode, $Subname, $internals, $Grade, $Credits, $Credits_pts, $Result_date)
    {
        // Extract the first three digits of Subcode
        $Regulation = substr($Subcode, 0, 3);

        // Check if a record with the given Htno and Subcode exists in student_results
        $checkQuery = "SELECT * FROM student_results WHERE Htno='$Htno' AND Subcode='$Subcode'";
        $checkResult = $conn->query($checkQuery) or die("Error in check Query" . $conn->error);

        if ($checkResult->num_rows > 0) {
            // Update existing row in student_results
            $row = $checkResult->fetch_assoc();
            $existingGrade = $row['Grade'];
            $existingResultDate = $row['Result_date'];

            // Append new data to existing data with a comma
            $newGrade = $existingGrade . ',' . $Grade;
            $newResultDate = $existingResultDate . ',' . $Result_date;

            $updateQuery = "UPDATE student_results SET Regulation='$Regulation', Year='$Year', Sem='$Sem', Batch='$Batch', Branch='$Branch', Subname='$Subname', Internals='$internals', Grade='$newGrade', Credits='$Credits', Credits_pts='$Credits_pts', Result_date='$newResultDate' WHERE Htno='$Htno' AND Subcode='$Subcode'";
            $updateResult = $conn->query($updateQuery) or die("Error in update Query" . $conn->error);

            // Update the same data in student_results_x
            $updateQueryX = "UPDATE student_results_x SET Regulation='$Regulation', Year='$Year', Sem='$Sem', Batch='$Batch', Branch='$Branch', Subname='$Subname', Internals='$internals', Grade='$newGrade', Credits='$Credits', Credits_pts='$Credits_pts', Result_date='$newResultDate' WHERE Htno='$Htno' AND Subcode='$Subcode'";
            $updateResultX = $conn->query($updateQueryX) or die("Error in update Query for student_results_x" . $conn->error);

            return array('updatedCount' => $conn->affected_rows, 'insertedCount' => 0);
        } else {
            // Insert new row in student_results
            $insertQuery = "INSERT INTO student_results SET Htno='$Htno', Regulation='$Regulation', Year='$Year', Sem='$Sem', Batch='$Batch', Branch='$Branch', Subcode='$Subcode', Subname='$Subname', Internals='$internals', Grade='$Grade', Credits='$Credits', Credits_pts='$Credits_pts', Result_date='$Result_date'";
            $insertResult = $conn->query($insertQuery) or die("Error in insert Query" . $conn->error);

            // Insert the same data into student_results_x
            $insertQueryX = "INSERT INTO student_results_x SET Htno='$Htno', Regulation='$Regulation', Year='$Year', Sem='$Sem', Batch='$Batch', Branch='$Branch', Subcode='$Subcode', Subname='$Subname', Internals='$internals', Grade='$Grade', Credits='$Credits', Credits_pts='$Credits_pts', Result_date='$Result_date'";
            $insertResultX = $conn->query($insertQueryX) or die("Error in insert Query for student_results_x" . $conn->error);

            return array('updatedCount' => 0, 'insertedCount' => 1);
        }
    }
}

?>