<?php
ini_set('memory_limit', '-1');
session_start();
     include '../../../connection.php';
if (isset($_SESSION['branch'])) {
    $branch = $_SESSION['branch'];
    } // Get the branch value from the session
    
    // Export data code using csv
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=R16_student_credits_report.csv');
        $output = fopen("php://output", "w");
       fputcsv($output, array('Htno','Regulation','Year1sem1', 'Year1sem2', 'Year2sem1', 'Year2sem2', 'Year3sem1', 'Year3sem2', 'Year4sem1', 'Year4sem2','Total'));
        if(empty($branch)) 
        {
            $query = "SELECT htno,regulation, year1sem1, year1sem2, year2sem1, year2sem2, year3sem1, year3sem2, year4sem1,year4sem2,total_credits
                FROM student_credits 
                WHERE regulation = 'R16'   ORDER BY Htno ASC";
        } 
        else 
        {
            $query = "SELECT htno,regulation, year1sem1, year1sem2, year2sem1, year2sem2, year3sem1, year3sem2, year4sem1,year4sem2,total_credits
                FROM student_credits 
                WHERE regulation = 'R16' AND branch='$branch'  
                ORDER BY Htno ASC";  
        }           
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
        fclose($output);
    
?>
