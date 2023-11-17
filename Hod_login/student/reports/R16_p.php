<?php
ini_set('memory_limit', '-1');
    session_start();
    include '../../../connection.php';
if (isset($_SESSION['branch'])) 
{
    $branch = $_SESSION['branch']; // Get the branch value from the session
    }// Set variables for connection
    
    // Export data code using csv
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=R16_Percentage_and_GPA_Report.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('Htno','Regulation','SGPA 1-1','SGPA 1-2','SGPA 2-1','SGPA 2-2','SGPA 3-1','SGPA 3-2','SGPA 4-1','SGPA 4-2','CGPA','Percentage','10th','inter/diploma','gmail'));
        if(empty($branch)) 
        {
            $query = "SELECT Htno,Regulation, Year1sem1, Year1sem2, Year2sem1, Year2sem2, Year3sem1, Year3sem2, Year4sem1, Year4sem2, CGPA, Per,10th,12th_or_diploma,gmail
                FROM student_details 
                WHERE Regulation = 'R16' 
                ORDER BY Htno ASC";
        } 
        else 
        {  
            $query = "SELECT Htno,Regulation, Year1sem1, Year1sem2, Year2sem1, Year2sem2, Year3sem1, Year3sem2, Year4sem1, Year4sem2, CGPA, Per,10th,12th_or_diploma,gmail
                FROM student_details 
                WHERE Regulation = 'R16' AND branch='$branch'
                ORDER BY Htno ASC";
        } 
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
        fclose($output);
    
?>

