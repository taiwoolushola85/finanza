<?php
include '../config/db.php';
include '../config/user_session.php';
$id = $_POST['id'];
$Query = "SELECT * FROM flexi_history WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
if($row != 0){
$ids = $row['id'];
$fn = $row['Firstname']. " ".$row['Othername'];
$lo = $row['Location'];
echo json_encode(array("historyId"=>$ids, "fullName"=>$fn, "recieptLocation"=>$lo));
}else{
// no data
}
mysqli_close($con);
?>