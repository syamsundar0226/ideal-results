<?php
ini_set('memory_limit', '-1');
include '../../../../connection.php';
include_once  "Common.php";

if ($_FILES['excelDoc']['name']) {
    $arrFileName = explode('.', $_FILES['excelDoc']['name']);
    if ($arrFileName[1] == 'csv') {
        $handle = fopen($_FILES['excelDoc']['tmp_name'], "r");
        $count = 0;
        $insertedCount = 0;
        $updatedCount = 0;
        $errorCount = 0; // New variable to track errors
        $errorMessages = array(); // Array to store error messages

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $count++;
            if ($count == 1) {
                continue; // skip the heading header of the sheet
            }
            $Htno = $conn->real_escape_string($data[0]);
            $Year = $conn->real_escape_string($data[1]);
            $Sem = $conn->real_escape_string($data[2]);
            $Batch = $conn->real_escape_string($data[3]);
            $Branch = $conn->real_escape_string($data[4]);
            $Subcode = $conn->real_escape_string($data[5]);
            $Subname  = $conn->real_escape_string($data[6]);
            $internals  = $conn->real_escape_string($data[7]);
            $Grade = $conn->real_escape_string($data[8]);
            $Credits = $conn->real_escape_string($data[9]);
            $Credits_pts = $conn->real_escape_string($data[10]);
            $Result_date = $conn->real_escape_string($data[11]);
            $common = new Common();
            $SheetUpload = $common->uploadData($conn, $Htno, $Year, $Sem, $Batch, $Branch, $Subcode, $Subname, $internals, $Grade, $Credits, $Credits_pts, $Result_date);

            if ($SheetUpload) {
                $updatedCount += $SheetUpload['updatedCount'];
                $insertedCount += $SheetUpload['insertedCount'];
            } else {
                $errorCount++;
                $errorMessages[] = "Error occurred at row $count: Failed to upload data.";
                break; // Stop uploading at the first error
            }
        }

        $totalCount = $count - 1;

        if ($errorCount > 0) {
            $errorMessage = implode("\n", $errorMessages);
            echo "<script>alert('Error occurred while uploading data:\\n$errorMessage'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Uploaded Successfully. Updated results: $updatedCount, New Results: $insertedCount, Total: $totalCount'); window.location.href='index.php';</script>";
        }

        exit();
    }
}
?>
