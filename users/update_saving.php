<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT * FROM save WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$fn = $row['Firstname']. " ".$row['Lastname'];
$amt = $row['Savings'];
echo json_encode(array("saveId"=>$ids, "fullName"=>$fn, "amountPaid"=>$amt));
}else{
// no data
}
?>