<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT id, Total_Bal, Surname, Firstname, Location FROM flexi_account WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$tot = $row['Total_Bal'];
$lok = $row['Location'];
$ann = $row['Surname']." ".$row['Firstname'];
echo json_encode(array("cusId"=>$ids, "cusBal"=>$tot, "cusName"=>$ann, "cusLoc"=>$lok));

}else{

}
mysqli_close($con);
?>