<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT * FROM holidays WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$role_name = $row['Holiday_Date'];
$cat = $row['Discription'];
echo json_encode(array("branchId"=>$ids, "branchName"=>$role_name, "disCrpition"=>$cat));

}else{

}
mysqli_close($con);
?>