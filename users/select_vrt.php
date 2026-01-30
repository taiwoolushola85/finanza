<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT * FROM repayments WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$id = $row['id'];
$vrt = $row['Account_Number'];
echo json_encode(array("repId"=>$ids, "vrtAcct"=>$vrt));
}else{
//
}
mysqli_close($con);
?>