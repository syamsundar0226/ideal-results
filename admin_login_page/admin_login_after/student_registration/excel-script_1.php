<?php
ini_set('memory_limit', '-1');
include '../../../connection.php';
include_once  "Common_1.php";

$uploadError = "";

if ($_FILES['excelDoc']['name']) {
    $arrFileName = explode('.', $_FILES['excelDoc']['name']);
    if ($arrFileName[1] == 'csv') {
        $handle = fopen($_FILES['excelDoc']['tmp_name'], "r");
        $count = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $count++;
            if ($count == 1) {
                continue; // skip the heading header of sheet
            }
            $sno = $conn->real_escape_string($data[0]);
            $Htno = $conn->real_escape_string($data[1]);
            $regulation=$conn->real_escape_string($data[2]);
            $branch = $conn->real_escape_string($data[3]);
            $st_name = $conn->real_escape_string($data[4]);
            $st_phone = $conn->real_escape_string($data[5]);
            $parent_phone = $conn->real_escape_string($data[6]);
            $tenth = $conn->real_escape_string($data[7]);
            $inter_or_diploma = $conn->real_escape_string($data[8]);
            $gmail = isset($data[9]) ? $conn->real_escape_string($data[10]) : '';
            $common = new Common();
            $SheetUpload = $common->uploadData($conn,$sno,$Htno,$regulation,$branch,$st_name,$st_phone,$parent_phone,$tenth,$inter_or_diploma,$gmail);
        }
        if ($SheetUpload) {
            echo"<script>alert('Uploaded Successfully!');window.location.href='index.html';</script>";
            exit();
        } else {
            $uploadError ="<script>alert('Error: There was an error uploading the file!');window.location.href='index.html';</script>";
        }
    } else {
        $uploadError = "<script>alert('Error: Please upload a CSV file!');window.location.href='index.html';</script>";
    }
}

if (!empty($uploadError)) {
    echo "<select>";
    echo "<option value=''>$uploadError</option>";
    echo "</select>";
}
