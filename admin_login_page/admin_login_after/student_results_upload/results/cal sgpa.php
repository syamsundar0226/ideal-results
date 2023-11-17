<?php
ini_set('memory_limit', '-1');
include '../../../../connection.php';

// Calculate SGPA and CGPA for each student
$sql = "SELECT Htno, Year, Sem, SUM(Credits_pts) as total_credits_pts, SUM(Actual_credits) as total_actual_credits FROM student_results GROUP BY Htno, Year, Sem";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $htno, $year, $sem, $total_credits_pts, $total_actual_credits);
$data = array();
while (mysqli_stmt_fetch($stmt)) {
    $sgpa = 0;
    if ($total_actual_credits > 0) {
        $sgpa = round($total_credits_pts / $total_actual_credits,2);
    }
    $data[$htno][$year][$sem] = array("sgpa" => $sgpa, "total_actual_credits" => $total_actual_credits);
}
mysqli_stmt_close($stmt);

// Calculate CGPA and Percentage for each student
foreach ($data as $htno => $years) {
    $cgpa = 0;
    $total_actual_credits = 0;
    foreach ($years as $year => $sems) {
        foreach ($sems as $sem => $sgpa_data) {
            $total_actual_credits += $sgpa_data["total_actual_credits"];
            $cgpa += $sgpa_data["sgpa"] * $sgpa_data["total_actual_credits"];
        }
    }
    if ($total_actual_credits > 0) {
        $cgpa = round($cgpa / $total_actual_credits,2);
    }
    $percentage = ($cgpa - 0.75) * 10;

    // Update the student_sgpa table with the calculated CGPA and Percentage
    $sql_update = "UPDATE student_details SET Year1sem1=?, Year1sem2=?, Year2sem1=?, Year2sem2=?, Year3sem1=?, Year3sem2=?, Year4sem1=?, Year4sem2=?, CGPA=?, Per=? WHERE htno=?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "dddddddddds", $data[$htno][1][1]["sgpa"], $data[$htno][1][2]["sgpa"], $data[$htno][2][1]["sgpa"], $data[$htno][2][2]["sgpa"], $data[$htno][3][1]["sgpa"], $data[$htno][3][2]["sgpa"], $data[$htno][4][1]["sgpa"], $data[$htno][4][2]["sgpa"], $cgpa, $percentage, $htno);
    mysqli_stmt_execute($stmt_update);
    mysqli_stmt_close($stmt_update);
}

// Close database connection
mysqli_close($conn);

// Display an alert message based on whether GPA updates were successful or not
if (count($data) > 0) {
    echo "<script>alert('All GPA updates were successfully Completed');window.location.href='index.php';</script>";
} else {
    echo "<script>alert('No GPA updates were made');window.location.href='index.php';</script>";
}
?>
