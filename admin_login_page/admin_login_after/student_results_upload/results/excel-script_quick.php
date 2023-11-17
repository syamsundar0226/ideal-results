<?php
ini_set('memory_limit', '-1');
include '../../../../connection.php';
include_once  "Common_quick.php";

if ($_FILES['excelDoc']['name']) {
    $arrFileName = explode('.', $_FILES['excelDoc']['name']);
    if ($arrFileName[1] == 'csv') {
        $handle = fopen($_FILES['excelDoc']['tmp_name'], "r");
        $count = 0;
        $errorMessages = array();
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $count++;
            if ($count == 1) {
                continue; // skip the heading header of the sheet
            }
            $Htno = $conn->real_escape_string($data[0]);
            $Subcode = $conn->real_escape_string($data[1]);
            $Subname  = $conn->real_escape_string($data[2]);
            $internals  = $conn->real_escape_string($data[3]);
            $Grade = $conn->real_escape_string($data[4]);
            $Credits = $conn->real_escape_string($data[5]);
            $common = new Common();
            $SheetUpload = $common->uploadData($conn, $Htno, $Subcode, $Subname, $internals, $Grade, $Credits);
        }
        if ($SheetUpload) {
            echo "<script>alert('Uploaded Successfully! Total results: " . ($count - 1) . "');window.location.href='ind_quick.php';</script>";
            exit();
        }
    }
}
?>
