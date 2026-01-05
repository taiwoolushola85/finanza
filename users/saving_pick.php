<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT id, Transaction_id, Balance, Firstname, Middlename FROM savings WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$tr = $row['Transaction_id'];
$tot = $row['Balance'];
$ann = $row['Firstname']." ".$row['Middlename'];
echo json_encode(array("cusId"=>$ids, "cusBal"=>$tot, "cusTran"=>$tr, "cusName"=>$ann));

}else{

}
mysqli_close($con);
?>