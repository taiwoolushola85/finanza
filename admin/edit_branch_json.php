<?php
include '../config/db.php';
$id = $_POST['id'];
$Query = "SELECT id, Name, State, Zone, Zone_id FROM branch WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$role_name = $row['Name'];
$cat = $row['State'];
$zn = $row['Zone'];
$znid = $row['Zone_id'];
echo json_encode(array("branchId"=>$ids, "branchName"=>$role_name, "branchState"=>$cat, "branchZone"=>$zn, "branchZoneid"=>$znid));

}else{

}
mysqli_close($con);
?>