<?php
ini_set('memory_limit', '-1');
session_start();
    include '../../../connection.php';
if (isset($_SESSION['branch'])) {
    $branch = $_SESSION['branch'];
    } // Get the branch value from the session
    
    // Export data code using csv
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=R19_Fail_Report.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('Htno','Regulation','Year','Sem','Batch','Branch','Subcode', 'Subname', 'Grade', 'Actual Credits','Credits', 'Credits_pts'));
        if(empty($branch)) 
        {
            $query = "SELECT Htno,Regulation, Year, Sem, Batch, Branch, Subcode, Subname, Grade,Actual_credits, Credits, Credits_pts FROM student_results WHERE (SUBSTRING_INDEX(Grade, ',', -1) = 'F' OR SUBSTRING_INDEX(Grade, ',', -1) = 'ABSENT') AND Regulation = 'R19'  ORDER BY Htno ASC";
        } 
        else 
        {  
            $query = "SELECT Htno,Regulation, Year, Sem, Batch, Branch, Subcode, Subname, Grade, Actual_credits,Credits, Credits_pts FROM student_results WHERE (SUBSTRING_INDEX(Grade, ',', -1) = 'F' OR SUBSTRING_INDEX(Grade, ',', -1) = 'ABSENT') AND Regulation = 'R19' AND Branch='$branch' ORDER BY Htno ASC";
        }      
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
        fclose($output);
    
?>
