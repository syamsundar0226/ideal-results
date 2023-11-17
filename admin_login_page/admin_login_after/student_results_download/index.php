<?php
// Connect to database
ini_set('memory_limit', '-1');
session_start();
include '../../../connection.php';
if (!isset($_SESSION['username'])) {
  header("Location: ../../../index.html"); // Redirect to login page
  exit(); // Stop executing the rest of the code
}


$msg = 0;

// Export data code using csv
if (isset($_POST['export'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Htno','Regulation','Year','Sem','Batch','Branch','Subcode', 'Subname', 'Grade','Actual Credits' ,'Credits', 'Credits_pts','Result_date', 'Mentor'));
    $query = "SELECT Htno,Regulation, Year , Sem , Batch , Branch , Subcode , Subname , Grade ,Actual_credits, Credits , Credits_pts, Result_date, Mentor from student_results ORDER BY Htno ASC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Results</title>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <link rel = "icon" href = "../../../ideal_logo.jpg" type = "image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <a href="../Admin login after.php" style="position: absolute;top: 50px; right: 50px; transform: translateY(-50%);">
  <i class="fa fa-home fa-3x" style="color: black;"></i>
</a>
    <div class="csv_section">
        <div class="export_section"></div>
            <form class="form-horizontal" action="" method="post" name="uploadCSV" enctype="multipart/form-data">
                <div class="input-row" style="margin-top: 8px;">
                    <button type="submit" id="submit" name="export" class="btn-submit" style="display:block; margin-left:500px; background-color: lightgreen; padding: 10px 10px; border: none; border-radius: 5px;">EXPORT CSV</button>
                </div>
                <div id="response"></div>
            </form>
        </div>
    </div>
    <div class="show_records">
    <?php
    $results_per_page = 50; // number of results to display per page
    $sql = "SELECT * from student_results ";
    $records = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($records);
    if ($rowcount > 0) {
        ?>
        <h2 class="cl">All student results List <span style="float:right;">Total : <?php echo $rowcount; ?></span></h2>
        <table id='joblisttable' style="float:left;">
            <thead>
                <tr>
                    <th>Sno</th>
                    <th>Htno</th>
                    <th>Year</th>
                    <th>Sem</th>
                    <th>Batch</th>
                    <th>Branch</th>
                    <th>Subcode</th>
                    <th>Subname</th>
                    <th>Internals</th>
                    <th>Grade</th>
                    <th>Credits</th>
                    <th>Credits_pts</th>
                    <th>Result_Date</th>
                    <th>Mentor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1; // get the current page number from the URL parameter
                $offset = ($page - 1) * $results_per_page; // calculate the offset for the SQL query
                $sql .= " LIMIT $offset, $results_per_page"; // append the limit clause to the SQL query
                $records = mysqli_query($conn, $sql); // execute the modified SQL query
                while ($row = mysqli_fetch_object($records)) {
                    ?>
                    <tr class="line-content">
                        <td><?php echo $row->sno; ?></td>
                        <td><?php echo $row->Htno; ?></td>
                        <td><?php echo $row->Year; ?></td>
                        <td><?php echo $row->Sem; ?></td>
                        <td><?php echo $row->Batch; ?></td>
                        <td><?php echo $row->Branch; ?></td>
                        <td><?php echo $row->Subcode; ?></td>
                        <td><?php echo $row->Subname; ?></td>
                        <td><?php echo $row->Internals; ?></td>
                        <td><?php echo $row->Grade; ?></td>
                        <td><?php echo $row->Credits; ?></td>
                        <td><?php echo $row->Credits_pts; ?></td>
                        <td><?php echo $row->Result_date; ?></td>
                        <td><?php echo $row->Mentor; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
      <?php
// display page numbers
$total_pages = ceil($rowcount / $results_per_page); // calculate the total number of pages
if ($total_pages > 1) {
    ?>
    <ul class="pagin">
        <?php
        $start_page = 1;
        $end_page = $total_pages;
        $num_links = 10; // the number of page links to display
        $half_links = floor($num_links/2); // the number of page links to display on either side of the current page

        // adjust the start and end page numbers based on the current page and the number of page links to display
        if ($total_pages > $num_links) {
            if ($page <= $half_links) {
                $start_page = 1;
                $end_page = $num_links;
            } else if ($page >= ($total_pages - $half_links)) {
                $start_page = $total_pages - $num_links + 1;
                $end_page = $total_pages;
            } else {
                $start_page = $page - $half_links;
                $end_page = $page + $half_links;
            }
        }

        // display the page links
        if ($start_page > 1) {
            ?>
            <li><a href="?page=1">1</a></li>
            <li><span>...</span></li>
            <?php
        }
        for ($i = $start_page; $i <= $end_page; $i++) {
            ?>
            <li <?php if ($i == $page) { echo 'class="active"'; } ?>>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php
        }
        if ($end_page < $total_pages) {
            ?>
            <li><span>...</span></li>
            <li><a href="?page=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a></li>
            <?php
        }
        ?>
    </ul>
    <?php
}}
?>
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="jquery.js" type="text/javascript"></script>
</body>
</html>