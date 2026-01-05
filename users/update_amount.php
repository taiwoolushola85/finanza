<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT * FROM history WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$lon = $row['Loan_Account_No'];
$fn = $row['Firstname']. " ".$row['Lastname'];
$am = $row['Amount'];
echo json_encode(array("historyId"=>$ids, "fullName"=>$fn, "loanAcct"=>$lon, "amountPaid"=>$am));
}else{
// no data
}
?>