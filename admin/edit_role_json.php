<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT id, Name, Categorys FROM role WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$role_name = $row['Name'];
$cat = $row['Categorys'];
echo json_encode(array("roleId"=>$ids, "roleName"=>$role_name, "roleCat"=>$cat));

}else{

}
mysqli_close($con);
?>