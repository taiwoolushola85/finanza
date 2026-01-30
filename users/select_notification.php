<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT * FROM nip_notifications WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$notid = $row['id'];
$amt = $row['amount'];
$vrt = $row['craccount'];
echo json_encode(array("notID"=>$notid, "notAmt"=>$amt, "notAcct"=>$vrt));
}else{
//
}
mysqli_close($con);
?>