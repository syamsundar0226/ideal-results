<?php
ini_set('memory_limit', '-1');
include  "../../../connection.php";
include_once  "Common.php";

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
            $branch = $conn->real_escape_string($data[2]);
            $username = $conn->real_escape_string($data[3]);
            $password = isset($data[4]) ? $conn->real_escape_string($data[4]) : '';
            $common = new Common();
            $SheetUpload = $common->uploadData($conn,$sno,$Htno,$branch,$username,$password);
        }
        if ($SheetUpload) {
            echo"<script>alert('Uploaded Successfully!');window.location.href='index.php';</script>";
            exit();
        } else {
            $uploadError ="<script>alert('Error: There was an error uploading the file!');window.location.href='index.php';</script>";
        }
    } else {
        $uploadError = "<script>alert('Error: Please upload a CSV file!');window.location.href='index.php';</script>";
    }
}

if (!empty($uploadError)) {
    echo "<select>";
    echo "<option value=''>$uploadError</option>";
    echo "</select>";
}
