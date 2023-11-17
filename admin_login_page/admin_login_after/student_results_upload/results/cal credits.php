<?php
ini_set('memory_limit', '-1');
// Database connection variables
include '../../../../connection.php';

// Construct the SQL statement to update Credits_pts for all records
$sql1 = "UPDATE student_results SET Credits_pts = (
    IF(Regulation IN ('R20', 'R23'), 
        CASE SUBSTRING_INDEX(GRADE, ',', -1)
            WHEN 'A+' THEN 10
            WHEN 'A' THEN 9
            WHEN 'B' THEN 8
            WHEN 'C' THEN 7
            WHEN 'D' THEN 6
            WHEN 'E' THEN 5
            WHEN 'F' THEN 0
            ELSE 0
        END,
        CASE SUBSTRING_INDEX(GRADE, ',', -1)
            WHEN 'O' THEN 10
            WHEN 'S' THEN 9
            WHEN 'A' THEN 8
            WHEN 'B' THEN 7
            WHEN 'C' THEN 6
            WHEN 'D' THEN 5
            WHEN 'F' THEN 0
            ELSE 0
        END
    ) * Credits
)";

if ($conn->query($sql1) === TRUE) {
    // First query executed successfully, now execute the second query
    $sql2 = "UPDATE student_credits AS sc
        JOIN (
            SELECT Htno,
                SUM(CASE WHEN Year = 1 AND Sem = 1 THEN Credits ELSE 0 END) AS year1sem1,
                SUM(CASE WHEN Year = 1 AND Sem = 2 THEN Credits ELSE 0 END) AS year1sem2,
                SUM(CASE WHEN Year = 2 AND Sem = 1 THEN Credits ELSE 0 END) AS year2sem1,
                SUM(CASE WHEN Year = 2 AND Sem = 2 THEN Credits ELSE 0 END) AS year2sem2,
                SUM(CASE WHEN Year = 3 AND Sem = 1 THEN Credits ELSE 0 END) AS year3sem1,
                SUM(CASE WHEN Year = 3 AND Sem = 2 THEN Credits ELSE 0 END) AS year3sem2,
                SUM(CASE WHEN Year = 4 AND Sem = 1 THEN Credits ELSE 0 END) AS year4sem1,
                SUM(CASE WHEN Year = 4 AND Sem = 2 THEN Credits ELSE 0 END) AS year4sem2
            FROM student_results
            GROUP BY Htno
        ) AS result_summary
        ON sc.Htno = result_summary.Htno
        SET sc.year1sem1 = result_summary.year1sem1,
            sc.year1sem2 = result_summary.year1sem2,
            sc.year2sem1 = result_summary.year2sem1,
            sc.year2sem2 = result_summary.year2sem2,
            sc.year3sem1 = result_summary.year3sem1,
            sc.year3sem2 = result_summary.year3sem2,
            sc.year4sem1 = result_summary.year4sem1,
            sc.year4sem2 = result_summary.year4sem2,
            sc.total_credits = result_summary.year1sem1 + result_summary.year1sem2 + result_summary.year2sem1 + result_summary.year2sem2 + result_summary.year3sem1 + result_summary.year3sem2 + result_summary.year4sem1 + result_summary.year4sem2";

    if ($conn->query($sql2) === TRUE) {
        // Second query executed successfully, now execute the third query
        $sql3 = "UPDATE student_results AS sr
            JOIN (
                SELECT Subcode, Branch, MAX(Credits) AS max_credits
                FROM student_results
                GROUP BY Subcode, Branch
            ) AS max_credits_table
            ON sr.Subcode = max_credits_table.Subcode AND sr.Branch = max_credits_table.Branch
            SET sr.Actual_credits = max_credits_table.max_credits";

        if ($conn->query($sql3) === TRUE) {
            echo "<script>alert('Credits, Credit points, and Actual credits calculated successfully...');window.location.href='index.php';</script>";
        } else {
            echo "Error Calculating Actual Credits: " . $conn->error;
        }
    } else {
        echo "Error Calculating Credits: " . $conn->error;
    }
} else {
    echo "Error Calculating Credit points: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
