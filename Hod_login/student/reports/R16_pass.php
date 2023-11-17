<?php
ini_set('memory_limit', '-1');
session_start();
include '../../../connection.php';

if (isset($_SESSION['branch'])) {
    $branch = $_SESSION['branch'];
}

// Export data code using csv
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=R16_Pass_Report.csv');
$output = fopen("php://output", "w");
fputcsv($output, array('Htno','Regulation', 'Year1sem1', 'Year1sem2', 'Year2sem1', 'Year2sem2', 'Year3sem1', 'Year3sem2', 'Year4sem1', 'Year4sem2', 'CGPA', 'Percentage'));

if (empty($branch)) {
    $query = "SELECT sd.htno, sd.regulation,sd.Year1sem1, sd.Year1sem2, sd.Year2sem1, sd.Year2sem2, sd.Year3sem1, sd.Year3sem2, sd.Year4sem1, sd.Year4sem2, sd.CGPA, sd.Per
            FROM student_details AS sd
            WHERE sd.htno IN (
                SELECT sr.Htno
                FROM student_results AS sr
                WHERE sr.regulation = 'R19'
                GROUP BY sr.Htno
                HAVING SUM(CASE WHEN SUBSTRING_INDEX(sr.Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) = 0
            )";
} else {
    $query = "SELECT sd.htno,sd.regulation, sd.Year1sem1, sd.Year1sem2, sd.Year2sem1, sd.Year2sem2, sd.Year3sem1, sd.Year3sem2, sd.Year4sem1, sd.Year4sem2, sd.CGPA, sd.Per
            FROM student_details AS sd
            WHERE sd.htno IN (
                SELECT sr.Htno
                FROM student_results AS sr
                WHERE sr.regulation = 'R19'
                GROUP BY sr.Htno
                HAVING SUM(CASE WHEN SUBSTRING_INDEX(sr.Grade, ',', -1) IN ('F', 'ABSENT') THEN 1 ELSE 0 END) = 0
            ) AND sd.branch = '$branch'";
}

$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}
fclose($output);
?>
