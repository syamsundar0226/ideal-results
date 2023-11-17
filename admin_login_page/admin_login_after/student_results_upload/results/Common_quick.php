<?php  
class Common
{
  public function uploadData($conn, $Htno, $Subcode, $Subname,$internals, $Grade, $Credits)
  {
    // inserting new data
    $insertQuery = "INSERT INTO quick_results SET Htno='$Htno', Subcode='$Subcode', Subname='$Subname',Internals='$internals', Grade='$Grade', Credits='$Credits'";
    $result = $conn->query($insertQuery) or die("Error in insert Query".$conn->error);
    
    return $result;
  }
}
?>